<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
?>
<div class="btn-group mb-3" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary" onclick="fireflies.orderHotels(<?=$search_id ?? '';?>, 'min_price')"><?=lang('default.00007')?></button>
    <button type="button" class="btn btn-primary" onclick="fireflies.orderHotels(<?=$search_id ?? '';?>, 'stars')"><?=lang('default.00009')?></button>
    <button type="button" class="btn btn-primary" onclick="fireflies.orderHotels(<?=$search_id ?? '';?>, 'distance')"><?=lang('default.00010')?></button>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= lang('default.00003'); ?></th>
        <th scope="col"><?= lang('default.00004'); ?></th>
        <th scope="col"><?= lang('default.00005'); ?></th>
        <th scope="col"><?= lang('default.00006'); ?></th>
        <th scope="col"><?= lang('default.00007'); ?></th>
        <th scope="col"><?= lang('default.00008'); ?></th>
        <th scope="col"><?= lang('default.00011'); ?></th>
    </tr>
    </thead>
    <?php

    if (isset($hotels) && !empty($hotels)) {
        foreach ($hotels as $hotel) {
            if ($hotel instanceof HotelModel) {
                ?>
                <tr>
                    <td><?= $hotel->getName(); ?></td>
                    <td><?= $hotel->getCountry(); ?></td>
                    <td><?= $hotel->getCity(); ?></td>
                    <td><?= $hotel->getAddress(); ?></td>
                    <td><?= $hotel->getMinPrice(); ?></td>
                    <td><?= $hotel->getDistance(); ?></td>
                    <td><?= $hotel->getStars(); ?></td>
                </tr>
                <?php

            }
        }
    }
    ?>
</table>
