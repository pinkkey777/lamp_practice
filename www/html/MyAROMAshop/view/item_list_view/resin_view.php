
            <h2>樹脂系</h2>
              <div class="flex">
               <?php 
               foreach($sales as $value){ 
                if($value['status'] === 0 && $value['type'] === 'resin' ){?>
               <div class="menu">
                  <span class="img"><img src="<?php print h(ITEM_IMAGE_DIR.$value['img']);?>" width=250px height=250px></span>
                  <span class="name"><?php print h($value['name']);?></span>
                  <span><?php print $value['price'];?>円</span>
                  
                  <?php if($value['stock'] <= 0){?>
                  <span class="soldout">売り切れ</span>
            　 </div>
                   <?php }else{?>
              <form method="post" action="top_add_cart.php">
                <label for="amount">数量</label>
                <select class="amount_select "name="amount" value="<?php print $value['amount']; ?>">
                  <?php $i=1; while($i <= 10){ ?>
                  <option value="<?php print $i; ?>"><?php print $i; ?></option>
                  <?php $i++; } ?>
                  <input class="cart_submit" type="submit" value="カートに入れる" name="in_cart">
                  <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>"/>
                  <input type="hidden" name="price" value="<?php print $value['price'];?>"/>
                  <input type="hidden" name="stock" value="<?php print $value['stock'];?>"/>
                  <input type="hidden" name="user_id" value="<?php print $user['user_id'];?>"/>
                  <input type="hidden" name="get_token" value="<?php print $token ; ?>"/>
                  <input type="hidden" name="process_kind" value="in_cart"/>
                  </form>
              </div>
                   <?php }}}?>