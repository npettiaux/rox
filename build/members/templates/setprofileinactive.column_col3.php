<!--
/*

Copyright (c) 2007 BeVolunteer

This file is part of BW Rox.

BW Rox is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BW Rox is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/> or 
write to the Free Software Foundation, Inc., 59 Temple PlaceSuite 330, 
Boston, MA  02111-1307, USA.

*/
/** 
 * @author matthias (globetrotter_tt)
 * @author Fake51
 */

-->
<form class="yform full" method="post" action="">
<?php
    if ($this->switchNotAllowed) {
        echo '<p><br />' . $words->get('ProfileSetInactiveNotAllowed', substr($this->member->LastSwitchToActive, 0,16)) . '</p>';
    } else {
?>
    <?php echo $this->getCallbackOutput('MembersController','setProfileInactiveCallback'); ?>
    <p><br /><?php echo $words->getFormatted('ProfileSetInactiveInfo'); ?></p>
    <p class="center">
    <input type="submit" class="button" value="<?php echo $words->getBuffered('ProfileSetInactive') ?>" />
        <?php echo $words->flushBuffer(); ?>    </p>
<?php } ?>
</form>
