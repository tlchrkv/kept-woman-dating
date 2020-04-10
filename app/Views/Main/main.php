<?php
/**
 * @var array $men
 * @var array $women
 */
?>

<div class="main">
    <div class="heading">
        <h1>Хотите найти богатого любовника?</h1>
        <form method="GET" action="/search">
            <h4>Поиск</h4>

            <div class="search">
                <div class="form-group">
                    <label>Показать<br>
                        <input type="checkbox" id="sexChoice1" name="sex[]" value="man">
                        <label for="sexChoice1">👨 Мужчину</label>
                        <br>
                        <input type="checkbox" id="sexChoice2" name="sex[]" value="woman">
                        <label for="sexChoice2">👩 Девушку</label>
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        Город <br>
                        <select name="googleGeoId[]" class="google-geo-select" multiple=""></select>
                    </label>
                </div>
            </div>
            <div class="form-group age-group">
                <div>Возраст</div>
                <div class="range">
                    <label>от<input type="number" name="ageFrom"></label>
                    <label>до<input type="number" name="ageTo"></label>
                </div>
            </div>
            <div class="button-group">
                <button type="submit">Найти</button>
            </div>
        </form>
    </div>

    <?php if (!empty($women)): ?>
    <h3>Ищут спонсора</h3>
    <div class="results">
        <?php
        for ($i = 0; count($women) < 3 ? $i < count($women) : $i <= 3; $i++):
            ?>
            <a href="/user/<?=$women[$i]['id']?>" class="profile">
                <div class="image" style="background-image: url('<?=$women[$i]['clientPath']?>')"></div>
                <div class="about-wrap">
                    <div class="about"><span class="name"><?=$women[$i]['name']?></span>, <?=$women[$i]['age']?></div>
                    <?=\Core\ServiceContainer::getInstance()->get('is_user_online_service')->getViewElement($women[$i]['sex'], $women[$i]['isConnected'], $women[$i]['lastConnected'])?>
                    <div class="city"><?=$women[$i]['city']?></div>
                </div>
            </a>
        <?php
        endfor;
        ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($men)): ?>
    <h3>Спонсоры</h3>
    <div class="results">
        <?php
        for ($i = 0; count($men) < 3 ? $i < count($men) : $i <= 3; $i++):
            ?>
            <a href="/user/<?=$men[$i]['id']?>" class="profile">
                <div class="image" style="background-image: url('<?=$men[$i]['clientPath']?>')"></div>
                <div class="about-wrap">
                    <div class="about"><span class="name"><?=$men[$i]['name']?></span>, <?=$men[$i]['age']?></div>
                    <?=\Core\ServiceContainer::getInstance()->get('is_user_online_service')->getViewElement($men[$i]['sex'], $men[$i]['isConnected'], $men[$i]['lastConnected'])?>
                    <div class="city"><?=$men[$i]['city']?></div>
                </div>
            </a>
        <?php
        endfor;
        ?>
    </div>
    <?php endif; ?>
    <div style="margin-top: 14px">
        <h2>Сайт знакомств с богатыми мужчинами</h2>
        <p>
            <strong>Ankira</strong> - это бесплатный сайт знакомств для взрослых, один из немногих специализированных ресурсов в мире, оказывающих реальную помощь в поисках содержанки для богатого мужчины. В интернете мы ведем активную рекламу, что позволяет нам привлекать огромное количество заинтересованных пользователей. Поиск на сайте максимально удобен и экономит время, которым не располагает каждый состоятельный мужчина. Для более эффективного поиска знакомства есть платные опции.
        </p>
        <p>
            Постоянно обновляемая доска объявлений и навигация по сайту позволят за секунды найти мужчину, знающей себе цену девушке. Наш сайт анонимных знакомств ежедневно посещают большое количество пользователей. Богатый мужчина, который ищет знакомства без обязательств, заглянув к нам, увидит здесь многочисленные объявления от привлекательных девушек: «ищу спонсора», «стану содержанкой». А содержанки находят у нас обеспеченных мужчин для интима и приятных встреч.
        </p>

        <h2>Знакомства без огласки для женатых и замужних</h2>
        <p>
            Основные пользователи сайта элитных знакомств Ankira – это успешные женатые мужчины, которые решили найти любовницу в сети для продолжительных отношений. Именно поэтому на сайте вы найдете тайные знакомства для женатых.
        </p>
        <p>
            Мы следим за тем, чтобы на сайте регистрировались только реальные люди. Ежедневно аудитория ресурса растет, что позволяет девушке найти мужчину, а мужчине любовницу в любом регионе мира. Общение на сайте безопасное и комфортное, а также есть платные функции для более эффективных знакомств. Наша служба поддержки всегда рада помочь нашим пользователям.
        </p>

        <h2>Содержанка: «ищу спонсора»</h2>
        <p>
            Любая современная девушка не хочет быть просто любовницей при богатом папике. Девушки не только привлекательны внешне, но и образованы, часто имеют постоянную работу. А спонсор нужен им для того, чтобы позволить себе чуть больше того, что они могут иметь. При этом любовница готова хранить верность своему единственному, а взамен ожидает получить достойное обеспечение ее основных нужд, дорогостоящие подарки и путешествия.
        </p>
        <p>
            Спонсор – это успешный, не всегда одинокий человек. При этом официально он может быть женат, но недополучает в семье внимание и любовь и поэтому размещает объявление: «ищу любовницу» или «ищу девушку для сопровождения». Среди пользователей сайта Ankira можно увидеть политиков, топ-менеджеров известных компаний, бизнесменов и звезд шоу-бизнеса. Для них любовница – это та девушка для досуга, с которой они хотели бы приятно проводить время и не обременять себя обязательствами.
        </p>
        <p>
            Девушка при этом не ограничивает свободу своего дарителя. Спонсор содержит ее и выполняет некоторые прихоти. Содержанка может проводить с партнером свободное время, путешествовать, сопровождать его на мероприятиях. Ради знакомства с богатыми мужчинами многие девушки готовы забыть о своих нуждах. Но только мудрые женщины становятся отдушиной для состоятельного человека и дают ему именно то, что ему не хватало до момента знакомства с девушкой: тепло, ласку, интимную близость, приятное общение. По признанию посетителей сайта, содержанка – это женщина всей их жизни.
        </p>

        <h2>Знакомства с богатыми мужчинами – твой шанс быстро изменить свою жизнь</h2>
        <p>
            Мечта каждой девочки – принц на белом коне. И теперь каждая хотела бы видеть рядом с собой богатого мужчину или папика, который превратит их жизнь в сказку. Решая найти спонсора, девушки выбирают партнера, исходя из его материального положения. Спонсор или папик нужен и вполне успешным женщинам, которые понимают, что уровень достатка напрямую зависит от уровня образованности человека, его острого ума, добропорядочности и других положительных качеств.
        </p>
        <p>
            Спонсор с радостью обеспечит достойный уровень жизни содержанки. Ему будет приятно баловать любовницу дорогими подарками и вниманием. Такие мужчины не привыкли экономить и щедрость – это их основное качество. Ошибочно считать, что подобные отношения основаны на деньгах. Спонсор и содержанка чаще всего относятся друг к другу с теплотой и любовью. Но при этом каждый четко знает, чего ждать от партнера.
        </p>
        <p>
            На сайте Ankira дают объявление «ищу любовницу» мужчины, которые в состоянии обеспечить материальные запросы интересной ему девушки. Именно поэтому девушки для встреч с удовольствием подают объявления на наш сайт знакомств "ищу любовника", т.к. ищут возможность жить красиво и так, как это представляется им в мечтах.
        </p>
        <p>
            Знакомства с состоятельными мужчинами на Ankira – это начало новых отношений.
        </p>
    </div>
</div>
<script src="/node_modules/select2/dist/js/select2.full.js" type="application/javascript"></script>
<script>
    $(".google-geo-select").select2({
        width: '169px',
        placeholder: "Выберите город",
        ajax: {
            url: '/geo-search',
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            data: function (term) {
                return {
                    name: term.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
</script>
