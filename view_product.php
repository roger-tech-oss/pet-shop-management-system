<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-start;
    font-size: 1.5em;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    color: gray;
    cursor: pointer;
}

.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
}
</style>

<?php 
 $products = $conn->query("SELECT * FROM `products`  where md5(id) = '{$_GET['id']}'");

 if($products->num_rows > 0){
     foreach($products->fetch_assoc() as $k => $v){
         $$k= $v;
     }
    $upload_path = base_app.'/uploads/product_'.$id;
    $img = "";
    if(is_dir($upload_path)){
        $fileO = scandir($upload_path);
        if(isset($fileO[2]))
            $img = "uploads/product_".$id."/".$fileO[2];
        // var_dump($fileO);
    }
    $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$id);
    $inv = array();
    while($ir = $inventory->fetch_assoc()){
        $inv[] = $ir;
    }
 }

 $feedback = $conn->query("SELECT * FROM `feedback` join clients on clients.id = feedback.client_id where product_id = $id");
 $myFeedback = $conn->query("SELECT * FROM `feedback` where product_id = $id and client_id = '{$_settings->userdata('id')}' ");
?>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0 " loading="lazy" id="display-img" src="<?php echo validate_image($img) ?>" alt="..." />
                <div class="mt-2 row gx-2 gx-lg-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-start">
                    <?php 
                        foreach($fileO as $k => $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                        <a href="javascript:void(0)" class="view-image <?php echo $k == 2 ? "active":'' ?>"><img src="<?php echo validate_image('uploads/product_'.$id.'/'.$img) ?>" loading="lazy"  class="img-thumbnail" alt=""></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <!-- <div class="small mb-1">SKU: BST-498</div> -->
                <h1 class="display-5 fw-bolder"><?php echo $product_name ?></h1>
                <div class="fs-5 mb-5">
                &#8369; <span id="price"><?php echo $inv[0]['price'] ?></span>
                <br>
                </div>
                <div class="fs-5 mb-5 d-flex justify-content-start">
                    <?php foreach($inv as $k => $v): ?>
                        <span><button class="btn btn-sm btn-flat btn-outline-dark m-2 p-size <?php echo $k == 0 ? "active":'' ?>" data-id="<?php echo $k ?>"><?php echo $v['size'] ?></button></span>
                    <?php endforeach; ?>
                </div>
                <form action="" id="add-cart">
                <div class="d-flex">
                    <input type="hidden" name="price" value="<?php echo $inv[0]['price'] ?>">
                    <input type="hidden" name="inventory_id" value="<?php echo $inv[0]['id'] ?>">
                    <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" name="quantity" />
                    <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Add to cart
                    </button>
                </div>
                </form>
                <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>

                <!--Rating-->
                <form action="rate_product.php" method="POST" id="ratingForm">
                    <div class="star-rating">
                        <input type="radio" name="rating" id="star5" value="5">
                        <label for="star5" title="5 stars">☆</label>
                        <input type="radio" name="rating" id="star4" value="4">
                        <label for="star4" title="4 stars">☆</label>
                        <input type="radio" name="rating" id="star3" value="3">
                        <label for="star3" title="3 stars">☆</label>
                        <input type="radio" name="rating" id="star2" value="2">
                        <label for="star2" title="2 stars">☆</label>
                        <input type="radio" name="rating" id="star1" value="1">
                        <label for="star1" title="1 star">☆</label>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">

                    <button type="submit">Submit Rating</button>
                </form>


                <!--Feedback-->
                <?php if($feedback->num_rows > 0): ?>
                    <div class="mt-5">
                        <?php while($row = $feedback->fetch_assoc()): ?>
                           
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php echo $row['feedback'] ?>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted"><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></small>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex">
                    <?php if(isset($_SESSION['userdata']) && $myFeedback->num_rows == 0): ?>
                        <form action="inc/feedback.php?id=<?php echo $_GET['id'] ?>" method="POST" id="feedback-form">
                            <input type="hidden" name="product_id" value="<?php echo $id ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_settings->userdata('id') ?>">
                            <div class="form-group">
                                <textarea name="feedback" id="feedback" cols="30" rows="3" class="form-control" placeholder="Leave feedback here"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php 
            $products = $conn->query("SELECT * FROM `products` where status = 1 and (category_id = '{$category_id}' or sub_category_id = '{$sub_category_id}') and id !='{$id}' order by rand() limit 4 ");
            while($row = $products->fetch_assoc()):
                $upload_path = base_app.'/uploads/product_'.$row['id'];
                $img = "";
                if(is_dir($upload_path)){
                    $fileO = scandir($upload_path);
                    if(isset($fileO[2]))
                        $img = "uploads/product_".$row['id']."/".$fileO[2];
                    // var_dump($fileO);
                }
                $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$row['id']);
                $_inv = array();
                while($ir = $inventory->fetch_assoc()){
                    $_inv[$ir['size']] = number_format($ir['price']);
                }
        ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <!-- Product image-->
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $row['product_name'] ?></h5>
                            <!-- Product price-->
                            <?php foreach($_inv as $k=> $v): ?>
                                <span><b><?php echo $k ?>: </b><?php echo $v ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary "   href=".?p=view_product&id=<?php echo md5($row['id']) ?>">View</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<script>
    var inv = $.parseJSON('<?php echo json_encode($inv) ?>');
    $(function(){
        $('.view-image').click(function(){
            var _img = $(this).find('img').attr('src');
            $('#display-img').attr('src',_img);
            $('.view-image').removeClass("active")
            $(this).addClass("active")
        })
        $('.p-size').click(function(){
            var k = $(this).attr('data-id');
            $('.p-size').removeClass("active")
            $(this).addClass("active")
            $('#price').text(inv[k].price)
            $('[name="price"]').val(inv[k].price)
            $('#avail').text(inv[k].quantity)
            $('[name="inventory_id"]').val(inv[k].id)

        })

        $('#add-cart').submit(function(e){
            e.preventDefault();
            if('<?php echo $_settings->userdata('id') ?>' <= 0){
                uni_modal("","login.php");
                return false;
            }
            start_loader();
            $.ajax({
                url:'classes/Master.php?f=add_to_cart',
                data:$(this).serialize(),
                method:'POST',
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status=='success'){
                        alert_toast("Product added to cart.",'success')
                        $('#cart-count').text(resp.cart_count)
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader();
                }
            })
        })
    })
</script>