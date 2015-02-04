<?php
/*
 * template content: 
 * shows the trip author with a picture, trip title, trip text ($trip->trip_descr),
 * number of destinations of the trip and action links (create, edit, delete, add destination)
 */
?>
<div class="float_left"><?=$layoutbits->PIC_50_50($trip->handle)?><?php echo $words->flushBuffer(); ?></div><h2 class="tripname"><?=$trip->trip_name; ?></h2>
        <div class="trip_author"><?=$words->get('by')?> <a href="members/<?php echo $trip->handle; ?>"><?php echo $trip->handle; ?></a>
            <a href="blog/<?php echo $trip->handle; ?>" title="Read blog by <?php echo $trip->handle; ?>"><img src="images/icons/blog.gif" style="vertical-align:bottom;" alt="" /></a>
            <a href="trip/show/<?php echo $trip->handle; ?>" title="Show trips by <?php echo $trip->handle; ?>"><img src="images/icons/world.gif" style="vertical-align:bottom;" alt="" /></a>

<div class="float_right">
<?php
if ($member)
{
?>
          <ul>
            <li class="float_left"><a href="trip/create" title="<?=$words->getSilent('TripTitle_create')?>"><img src="images/icons/world_add.png" style="vertical-align:bottom;" alt="<?=$words->getSilent('TripTitle_create')?>" /></a> <a href="trip/create" title="<?=$words->getSilent('TripTitle_create')?>"><?=$words->getSilent('TripTitle_create')?></a><?php echo $words->flushBuffer(); ?></li>
    <?php if ($member && !$isOwnTrip) { ?>            
            <li class="float_left"><a href="trip/show/<?=$member->Username?>" title="<?=$words->getSilent('TripsShowMy')?>"><img src="images/icons/world.png" style="vertical-align:bottom;" alt="<?=$words->getSilent('TripsShowMy')?>" /></a> <a href="trip/show/<?=$member->Username?>" title="<?=$words->getSilent('TripsShowMy')?>"><?=$words->getSilent('TripsShowMy')?></a><?php echo $words->flushBuffer(); ?></li>
    <?php    }?>
    <?php if ($isOwnTrip) { ?>
            <li class="float_left"><a href="trip/edit/<?=$trip->trip_id; ?>"><img src="styles/css/minimal/images/iconsfam/pencil.png" style="vertical-align:bottom;" alt="<?=$words->getSilent('Trip_EditMyTrip')?>" /></a> <a href="trip/edit/<?=$trip->trip_id; ?>" title="<?=$words->getSilent('Trip_EditMyTrip')?>"><?=$words->getSilent('Trip_EditMyTrip')?></a><?php echo $words->flushBuffer(); ?></li>
            <li class="float_left"><a href="trip/del/<?=$trip->trip_id; ?>"><img src="styles/css/minimal/images/iconsfam/delete.png" style="vertical-align:bottom;" alt="<?=$words->getSilent('Trip_DeleteMyTrip')?>" /></a> <a href="trip/del/<?=$trip->trip_id; ?>" title="<?=$words->getSilent('Trip_DeleteMyTrip')?>"><?=$words->getSilent('Trip_DeleteMyTrip')?></a><?php echo $words->flushBuffer(); ?></li>
            <li class="float_left"><a href="trip/<?=$trip->trip_id; ?>/#destination-form" title="<?=$words->getSilent('Trip_SubtripsCreate')?>"><img src="images/icons/note_add.png" style="vertical-align:bottom;" alt="<?=$words->getSilent('Trip_SubtripsCreate')?>" /></a> <a href="trip/<?=$trip->trip_id; ?>/#destination-form" title="<?=$words->getSilent('Trip_SubtripsCreate')?>"><?=$words->getSilent('Trip_SubtripsCreate')?></a><?php echo $words->flushBuffer(); ?></li>
    <?php    }?>
          </ul>
<?php 
} ?>
</div>
        </div>
<?php
$CntSubtrips = 0;
if ($trip_data) 
    $CntSubtrips = count($trip_data[$trip->trip_id]);

if (isset($trip->trip_descr) && $trip->trip_descr) {
echo '<p class="tripdesc">'.$trip->trip_descr.'</p>';
}
if (isset($trip->trip_text) && $trip->trip_text) {
	echo '<p>'.$trip->trip_text.'</p>';
} ?>