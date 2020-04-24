<?php
/**
 * @var array $me
 * @var array $groupsWithProducts
 */
?>

<div class="shop-page">
    <div class="finances">
        <h2>💳 Кошелек</h2>
        <div class="balance">
            <div><?=$me['money']?> руб</div>
        </div>
        <div class="put-money">
            <h3>Пополнить</h3>
            <form method="POST" action="/shop/put-money">
                <div class="form-group" style="margin-top: 0;">
                    <input name="amount" placeholder="Сумма" type="number">
                </div>
                <div class="button-group">
                    <button type="submit">Пополнить</button>
                </div>
            </form>
        </div>
    </div>

<!--    <div class="active-products">-->
<!--        <h3>Активные продукты</h3>-->
<!--        <div></div>-->
<!--    </div>-->

    <div class="products">
        <?php foreach ($groupsWithProducts as $groupWithProducts): ?>
            <div class="group">
                <div class="name"><?=$groupWithProducts['name']?></div>
                <div class="about"><?=$groupWithProducts['about']?></div>
                <div class="products-list">
                    <?php foreach ($groupWithProducts['products'] as $product): ?>
                        <div class="product">
                            <div class="name"><?=$product['name']?></div>
                            <div class="price">Цена: <?=$product['price']?> руб</div>
                            <a class="button" href="/shop/buy/<?=$product['id']?>">Активировать</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<!--    <div class="history">-->
<!--        <h3>История</h3>-->
<!--        <div style="display: flex">-->
<!--            <div>Пополнения счета</div>-->
<!--            <div>Покупки</div>-->
<!--        </div>-->
<!--    </div>-->
</div>
