<?php
namespace SimpleAjax;
use WC_Cart;
class SimpleAjax extends SimpleAjaxTemplate {

	public $action=[];

	public function __construct($action) {

	    parent::__construct();

	    $this->action=$action;

		foreach ($this->action as $item){

			add_action(
				'wp_ajax_'.$item,
				array( $this, $item)
			);

			add_action(
				'wp_ajax_nopriv_'.$item,
				array( $this, $item )
			);

		}
	}

	public function cartUpdate(){

        echo json_encode([
            'items'=>WC()->cart->get_cart_contents_count(),
            'price'=>WC()->cart->get_cart_total()
        ]);
        wp_die();
    }

    public function removeFromBasket(){

        if(WC()->cart->remove_cart_item( $_POST['cart_item_key'] )){
            echo 1;
        } else{
            echo 0;
        }

        wp_die();
    }

    public function quantityCartItems(){

        // Set item key as the hash found in input.qty's name
        $cart_item_key = $_POST['cart_item_key'];

        // Get the array of values owned by the product we're updating
        $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

        // Get the quantity of the item in the cart
        $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

        // Update cart validation
        $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

        // Update the quantity of the item in the cart
        if ( $passed_validation ) {
            WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
        }
        wp_die();
    }

    public function set_quantity_products(){
        global $woocommerce;
        $woocommerce->cart->set_quantity($_POST['key'], $_POST['value']);
        wp_die();
    }

    public function create_order(){

        $address = array(
            'first_name' => $_POST['first_name'],//$_POST['first_name'],
            'email'      => $_POST['email'],//$_POST['email'],
            'phone'      => $_POST['phone'],//$_POST['phone'],
//            'address_1'  => $_POST['address_1'],//$_POST['address_1'],
            'country'    => 'RU'
        );

        $order =wc_create_order();
        foreach (WC()->cart->get_cart() as $item){
            $product = apply_filters('woocommerce_cart_item_product',$item['data'],$item,$item['key']);
            $order->add_product($product,$item['quantity']);
        }

        $order->set_address( $address, 'billing' );
        $order->set_address( $address, 'shipping' );
//        $order->set_customer_note($_POST['note']);//$_POST['note']
        if($_POST['note']){
            $note='';
            $note .='Завка оформлена от Юридического лица.  ';
            $note .= 'Юридическое название: '.$_POST['note']['entity_name'] .' ';
            $note .= 'ИНН: '.$_POST['note']['entity_inn'].' ';
            $note .= 'КПП: '.$_POST['note']['entity_kpp'].' ';
            $note .= 'БИК: '.$_POST['note']['entity_bik'].' ';
            $note .= 'РС: '.$_POST['note']['entity_rs'].' ';
            $note .= 'Счёт: '.$_POST['note']['entity_score'].' ';

            $order->set_customer_note($note);//$_POST['note']
        }
        $order->calculate_totals();

//        if(!isset($_POST['order'])){
//
//            echo json_encode(['order'=>$order]);
//        }
        echo true;
        wp_die();
    }

    public function add_shipping(){

        if(!isset($_POST['order'])){
            return false;
        }else{
            $order=wc_get_order($_POST['order']);
            if($order){

                $wcShipping = new WC_Shipping();
                $methodName= $wcShipping->get_shipping_method_class_names()[$_POST['shipping']];
                $shippingClass = new $methodName();
                $shippingItem = new WC_Order_Item_Shipping();

                if(!empty($order->get_shipping_methods())){
                    $order->remove_order_items('shipping');
                }

                $shippingItem->set_method_title( $shippingClass->method_title );
                $shippingItem->set_method_id( $_POST['shipping']);
                $shippingItem->set_total( $_POST['shipping']=='chelyabinsk'?$shippingClass->get_cost($_POST['area']):$shippingClass->cost );

                $order->add_item($shippingItem);
                $order->calculate_totals();
            }else{
                return false;
            }
        }
        wp_die();
    }

    public function add_payment(){

        if(!isset($_POST['order'])){
            return false;
        }else{
            $order=wc_get_order($_POST['order']);
            if($order){

                $order->set_payment_method($_POST['payment']);
                $order->calculate_totals();
                $this->empty_cart();
            }else{
                return false;
            }
        }
        wp_die();
    }

    public function empty_cart(){
        $cart = new WC_Cart();
        $cart->empty_cart( $clear_persistent_cart = true );
        wp_die();
    }

    public function searchProduct(){

        $args = [
            'post_type'=> 'product',
            'post_status'=> 'publish',
            'order'=> 'DESC',
            'orderby'=>'date',
            's'=> $_POST['val'],
            'exact'=>false,
            'posts_per_page'=> -1
        ];

        if((int)$_POST['mark'] !== 0){
            $args['tax_query'] =[
                    [
                        'taxonomy' => 'tax_marks',
                        'terms' => $_POST['mark'],
                        'field' => 'term_id',
                        'include_children' => true,
                        'operator' => 'IN'
                    ]
            ];
        }

        $result = get_posts( $args );
        if($result){
            foreach ($result as $item):?>
                <li ><a class="flex_row justify_start" href="<?=get_permalink($item->ID)?>"><img src="<?=get_the_post_thumbnail_url($item->ID)?>" alt=""><?=$item->post_title?></a></li>
            <?endforeach;
        }else{
            echo '<li>
                    <h3>ничего не найдено</h3><br>
                     позвонить по номеру '.get_field('phone','options').'<br> возможно это товар есть на складе, <br>но мы не успели добавить его на сайт
                     </li>>';
        }
        wp_die();
    }

    public function insertSimpleAjax(){
        unset($_POST['action']);

        $simpleAjaxDB = new SimpleAjaxDB();
        foreach ($_POST['data'] as $item){

            $simpleAjaxDB->insertFromId($item['description'],$item['id']);
        }

        wp_die();
    }

    function loadmore(){
        $posts = [];
	    $page = $_POST['page'] + 1; // следующая страница
        if(!empty($_POST['tax']) && !empty($_POST['tax_marks'])){
            $args = [
                'post_type' => 'product',
                'posts_per_page' => 20,
                'paged' =>  $page,
                'numberposts'=>-1,
                'tax_query'             => array(
                    array(
                        'taxonomy'      => 'tax_marks',
                        'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                        'terms'         => $_POST['tax_marks'],
                        'operator'      => 'AND' // Possible values are 'IN', 'NOT IN', 'AND'.
                    ),
                    array(
                        'taxonomy'      => $_POST['tax'],
                        'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                        'terms'         => $_POST['term_id']?$_POST['term_id']:get_queried_object()->term_id,
                        'operator'      => 'AND' // Possible values are 'IN', 'NOT IN', 'AND'.
                    ),
                )
            ];

        }
        else{
            if($_POST['tax'] == 'product_cat' || $_POST['tax'] == 'tax_marks')
            {

                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => 20,
                    'paged' =>  $page,
                    'numberposts'=>-1,
                    'tax_query'             => array(
                        array(
                            'taxonomy'      => $_POST['tax'],
                            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                            'terms'         => $_POST['term_id']?$_POST['term_id']:get_queried_object()->term_id,
                            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                        ),
                    )
                ];
            }
            else
            {

                $args = [
                    'post_type' => 'product',
                    'numberposts'=>-1,
                    'posts_per_page' => 20,
                    'paged' => $page
                ];
            }
        }

        foreach (get_posts( $args ) as $key=>$item):?>
            <div <?if($key==0):?>id="page_<?=$page?>"<?endif;?> class="new_item catalog-table__row pagination_item" data-marks="<?=get_terms_ids($item->ID,'tax_marks')?>">
                <div class="catalog-table__cell type">
                    <div class="type__text"><?=get_terms_title(get_the_terms($item->ID,'tax_marks'))?></div>
                    <a href="<?=get_page_link($item->ID)?>" class="d-block product-link"><?=$item->post_title?></a>
                </div>
                <div class="catalog-table__cell price">

                    <div class="serial-number">
                        <?=$item->_sku?>
                    </div>
                    <div class="price__text text_primary"><?=wc_get_price($item->ID)?> Р</div>
                </div>
                <div class="catalog-table__cell quantity">
                    <div class="number-input flex-shrink-0">
                        <input type="number" min="1" value="1" class="number-input__field">
                        <button class="number-input__control number-input__control_minus"></button>
                        <button class="number-input__control number-input__control_plus"></button>
                    </div>
                </div>
                <div class="catalog-table__cell cell-btn">
                    <div data-id="<?=$item->ID?>" class="btn btn_warn btn_md add_to_basket">отложить</div>
                </div>
            </div>
        <?endforeach;
        die();
    }
}