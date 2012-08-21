<?php
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
write to the Free Software Foundation, Inc., 59 Temple Place - Suite 330,
Boston, MA  02111-1307, USA.

*/


require_once ("menus.php");

// This just display the list of massmail
function DisplayAdminMassMailsList($TData) {
  global $title;
  $title = "Admin Mass Mails";
  require_once "header.php";

  Menu1("", ww('MainPage')); // Displays the top menu

  Menu2("admin/adminmassmails.php", ww('MainPage')); // Displays the second menu

  $MenuAction  = "            <li><a href=\"adminmassmails.php\">Admin Massmails</a></li>\n";
  $MenuAction .= "            <li><a href=\"adminmassmails.php?action=createbroadcast\">Create new broadcast</a></li>\n";
  if (HasRight("MassMail","Send")) { // if has right to trig
    $MenuAction .= "            <li><a href=\"adminmassmails.php?action=ShowPendingTrigs\">Trigger mass mails</a></li>\n";
  }

  DisplayHeaderShortUserContent("Admin Mails - Broadcast Messages","");
  ShowLeftColumn($MenuAction,VolMenu());

  echo "    <div id=\"col3\"> \n";
  echo "      <div id=\"col3_content\" class=\"clearfix\"> \n";
  echo "        <div class=\"info clearfix\">\n";

  $max = count($TData);

  for ($ii=0;$ii<$max;$ii++) {
      echo "<br \>&nbsp;&nbsp;&nbsp;&nbsp;* <font color=green>",$TData[$ii]->Name,"</font> (",$TData[$ii]->Status,") <a href=\"adminmassmails.php?action=edit&IdBroadCast=".$TData[$ii]->id."\">edit</a> | <a href=\"adminmassmails.php?action=prepareenque&IdBroadCast=".$TData[$ii]->id."\">prepare enqueue</a><br />" ;
  }

  echo "</div> <!-- info -->\n";

  require_once "footer.php";
} // end of DisplayAdminMassMailsList

// This prepare the enqueuing according to criteria
function DisplayAdminMassToApprove($ToApprove) {
  global $title;
  $title = "Admin Mass Mails";
  require_once "header.php";

  Menu1("", ww('MainPage')); // Displays the top menu

  Menu2("admin/adminmassmails.php", ww('MainPage')); // Displays the second menu

  $MenuAction  = "            <li><a href=\"adminmassmails.php\">Admin Massmails</a></li>\n";
  $MenuAction .= "            <li><a href=\"adminmassmails.php?action=createbroadcast\">Create new broadcast</a></li>\n";
  if (HasRight("MassMail","Send")) { // if has right to trig
    $MenuAction .= "            <li><a href=\"adminmassmails.php?action=ShowPendingTrigs\">Trigger mass mails</a></li>\n";
  }

  DisplayHeaderShortUserContent( "Admin Mails - Broadcast Messages", "");
  ShowLeftColumn($MenuAction,VolMenu());

  echo "    <div id=\"col3\"> \n";
  echo "      <div id=\"col3_content\" class=\"clearfix\"> \n";
  echo "        <div class=\"info clearfix\">\n";

  if (HasRight("MassMail","Send")) { // if has right to trig
    $max=count($ToApprove) ;
    echo "Pending messages to Send $max<br />\n" ;
    for ($ii=0;$ii<$max;$ii++) {
      $m=$ToApprove[$ii] ;
      echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;* <a href=\"adminmassmails.php?action=Trigger&IdBroadCast=$m->IdBroadcast&Name=$m->Name"."\">Trigger ",$m->Name,"(",$m->cnt,")</a><br />\n" ;
    }
  }

  echo "</div> <!-- info -->\n";

  require_once "footer.php";

} // end of DisplayAdminMassToApprove

// This prepare the enqueing according to criteria
function DisplayAdminMassprepareenque($rBroadCast,$TGroupList,$TCountries,$TData,$count=0,$countnonews=0,$query="") {
  global $title;
  $title = "Admin Mass Mails";
  require_once "header.php";

  Menu1("", ww('MainPage')); // Displays the top menu

  Menu2("admin/adminmassmails.php", ww('MainPage')); // Displays the second menu

  $MenuAction  = "            <li><a href=\"adminmassmails.php\">Admin Massmails</a></li>\n";
  $MenuAction .= "            <li><a href=\"adminmassmails.php?action=createbroadcast\">Create new broadcast</a></li>\n";
  if (HasRight("MassMail","Send")) { // if has right to trig
    $MenuAction .= "            <li><a href=\"adminmassmails.php?action=ShowPendingTrigs\">Trigger mass mails</a></li>\n";
  }


  DisplayHeaderShortUserContent( "Admin Mails - Broadcast Messages", "");
  ShowLeftColumn($MenuAction,VolMenu());

  $Name=$rBroadCast->Name ;
  $IdGroup=GetParam("IdGroup",0) ;
  $CountryIsoCode=GetParam("CountryIsoCode",0) ;

  echo "    <div id=\"col3\"> \n";
  echo "      <div id=\"col3_content\" class=\"clearfix\"> \n";
  echo "        <div class=\"info clearfix\">\n";

  echo " for broadcast <b>",$Name,"</b><br /><br />" ;
  if ($count>0) {
     echo "<center><table><tr bgcolor='#ffff66'><td>&nbsp;</td></tr><tr  bgcolor='#ffff66'><td> $count enqueued messages !<br /><i>$countnonews will not receive the mail because of their preference</td></tr><tr  bgcolor='#ffff66'><td>&nbsp;</td></tr></table></center>\n" ;
  }


  echo "<table><tr bgcolor='#ffffcc'><td>title</td><td>",ww("BroadCast_Title_".$Name),"</td></tr>" ;
  echo "<tr bgcolor='#ccff99'><td>body</td><td>",ww("BroadCast_Body_".$Name),"</td></tr>" ;
  echo "</table>\n" ;

  echo "<br /><form method=post action=adminmassmails.php name=adminmassmails>\n" ;
  echo "<input type=hidden Name=IdBroadCast value=".GetParam("IdBroadCast",0).">\n" ;
  echo "<table>" ;
  echo "<tr><th align=center colspan=2> Filtering the scope of the mass mail</tr></td>" ;
  echo "<tr><td>restrict to some members<br />(ex : lupochen;kiwiflave;jeanyves)</td><td><input type=text name=Usernames value=".GetStrParam("Usernames",""),"></td></tr>\n" ;

  echo "<tr><td>specify a country</td>" ;
  echo "<td><select name=\"CountryIsoCode\">" ;
  echo "<option value=0>all</option>" ;
  for ($ii=0;$ii<count($TCountries);$ii++) {
    echo "<option value=\"",$TCountries[$ii]->isoCode.'"' ;
    if (strcmp($TCountries[$ii]->isoCode,$CountryIsoCode) === 0) echo " selected";
    echo ">",$TCountries[$ii]->Name ;
    echo "</option>" ;

  }
  echo "</select></td></tr>\n" ;


  echo "<tr><td>specify a group</td>" ;
  echo "<td><select name=IdGroup>" ;
  echo "<option value=0>all</option>" ;
  for ($ii=0;$ii<count($TGroupList);$ii++) {
    echo "<option value=",$TGroupList[$ii]->id ;
    if ($TGroupList[$ii]->id==$IdGroup) echo " selected" ;
    echo ">",$TGroupList[$ii]->Name,":",$TGroupList[$ii]->Name ; 
    echo "</option>" ;

  }
  echo "</select></td></tr>\n" ;


  echo "<tr><td>member with status</td><td><input type=text name=MemberStatus value=\"".GetStrParam("MemberStatus","Active")."\"></td></tr>\n" ;
  if (IsAdmin() and ($query!="")) {
     echo "<tr><td align=center colspan=2>This will supersed the query</td></tr>\n" ;
     echo "<tr><td align=left colspan=2><textarea name=query cols=130 rows=5>",$query,"</textarea><br />Use Open Query <input type='checkbox' name='UseOpenQuery'></td></tr>\n" ;
  }
    if (HasRight('MassMail',"test")) {
     echo "<tr><td align=center colspan=2><input type=submit name=action value=test></td></tr>\n" ;
  }
  echo "</table>\n" ;


// if it was a test action display the result build from previous filtering
  if (GetStrParam("action")=="test") {
     $max=count($TData) ;
     echo "<table>\n"  ;
     echo "<tr><th colspan=3>This could be send  to $max members</th></tr>\n" ;
     echo "<tr align=left><th>Username</th><th>country</th>" ;
     if (IsAdmin()) echo "<th>email</th>" ;
     echo "<th>Status</th><th>Will try in</th></tr>" ;
     for ($ii=0;$ii<$max;$ii++) {
          $m=$TData[$ii] ;
          echo "<tr bgcolor='#00ffff'>" ;
          echo "<td>",$m->Username,"</td>" ;
          echo "<td>",getcountrynamebycode($m->isoCode),"</td>" ;
         if (IsAdmin()) echo "<td>",GetEmail($m->id),"</td>" ;
          echo "<td>",$m->Status,"</td>" ;
					$iLang=GetDefaultLanguage($m->id);
          $PrefLanguageName=LanguageName($iLang) ;
          echo "<td>",$PrefLanguageName,"</td>" ;

          echo "</tr>\n" ;
         echo "<tr>" ;
         echo "<td colspan=5 bgcolor='#c0c0c0'>" ;
         echo wwinlang("BroadCast_Title_".$Name,$iLang),"<br />" ;
         echo wwinlang("BroadCast_Body_".$Name,$iLang,$m->Username),"<br />" ;
         echo "</td>" ;
         echo "</tr>" ;
     }
     echo "</table>\n" ;
  }
  if (HasRight('MassMail',"enqueue")) {
     echo "<table><tr><td>Tick this if you really want to enqueue the messages to send and click on enqueue</td><td><input type='checkbox' name='enqueuetick'>&nbsp;&nbsp;<input type='submit' name='action' value='enqueue'></td></tr></table>\n" ;
  }
  echo "</form>\n";

  echo "<div> <!-- info -->\n";

  require_once "footer.php";
} // end of DisplayAdminprepareenque



function DisplayAdminMassMails($TData) {
  global $title;
  $title = "Admin Mass Mails";
  require_once "header.php";

  Menu1("", ww('MainPage')); // Displays the top menu

  Menu2("admin/adminmassmails.php", ww('MainPage')); // Displays the second menu

  $MenuAction  = "            <li><a href=\"adminmassmails.php\">Admin Massmails</a></li>\n";
  $MenuAction .= "            <li><a href=\"adminmassmails.php?action=createbroadcast\">Create new broadcast</a></li>\n";
  if (HasRight("MassMail","Send")) { // if has right to trig
    $MenuAction .= "            <li><a href=\"adminmassmails.php?action=ShowPendingTrigs\">Trigger mass mails</a></li>\n";
  }


  DisplayHeaderShortUserContent( "Admin Mails - Broadcast Messages","");
  ShowLeftColumn($MenuAction,VolMenu());

  $max = count($TData);
  $max = 0;

  echo "    <div id=\"col3\"> \n";
  echo "      <div id=\"col3_content\" class=\"clearfix\"> \n";
  echo "        <div class=\"info clearfix\">\n";

  echo "<table><tr><td align='right'>Please write here in </td><td bgcolor=yellow align=left>".LanguageName($_SESSION['IdLanguage'])."</td></table>";
  echo "<br />" ;
  // echo "<hr />\n";
  echo "<table>\n";
  echo "<form method=post action=adminmassmails.php>\n";
  echo "<input type=hidden name=IdBroadCast value=",$TData->IdBroadcast,">\n" ;
  echo "<tr><td>subject</td><td> <textarea name=subject  rows=1 cols=80>", GetParam(subject), "</textarea></td>";
  echo "<tr><td>body</td><td> <textarea name=body rows=10 cols=80>", GetParam(body), "</textarea></td>";
  echo "<tr><td>greetings</td><td> <textarea name=greetings rows=2 cols=80>", GetParam(greetings), "</textarea></td>";
  echo "\n<tr><td colspan=2 align=center>";
  echo "<input type='submit' name='action' value='find'>";
  if (empty($TData->IdBroadcast)) echo " <input type=submit name=action value=update>";
  else echo " <input type=submit name=action value=update>";
  echo "</td><td align=center>" ;
   if (HasRight('MassMail','Send')) {
     echo "Send <input type=checkbox name=send> ";
     echo " <input type=submit name=action value=send>";
  }
  echo "</td> ";
  echo "</form>\n";
  echo "</table>\n";
  echo "</div> <!-- info -->\n";

  require_once "footer.php";

}


// This function proposes (?) to create a broadcast
function DisplayFormCreateBroadcast($IdBroadCast=0, $Name = "",$BroadCast_Title_,$BroadCast_Body_,$Description, $Type = "") {
  global $title;
  $title = "Create a new broadcast";
  require_once "header.php";

  Menu1("", ww('MainPage')); // Displays the top menu

  Menu2("admin/adminmassmails.php", ww('MainPage')); // Displays the second menu

  $MenuAction  = "            <li><a href=\"adminmassmails.php\">Admin Massmails</a></li>\n";
  $MenuAction .= "            <li><a href=\"adminmassmails.php?action=createbroadcast\">Create new broadcast</a></li>\n";
  if (HasRight("MassMail","Send")) { // if has right to trig
    $MenuAction .= "            <li><a href=\"adminmassmails.php?action=ShowPendingTrigs\">Trigger mass mails</a></li>\n";
  }

  DisplayHeaderShortUserContent( "Admin Mails - Broadcast Messages","");
  ShowLeftColumn($MenuAction,VolMenu());

  echo "    <div id=\"col3\"> \n";
  echo "      <div id=\"col3_content\" class=\"clearfix\"> \n";
  echo "        <div class=\"info clearfix\">\n";

  echo "<form method=post action=adminmassmails.php>\n";
  echo "<input type=hidden name=IdBroadCast value=$IdBroadCast>";
  echo "<p class=\"note center\">Please write here in <strong>".LanguageName($_SESSION['IdLanguage'])."</strong></p>";
  echo "<table>";
  echo "<tr><td width=30%>Give the code name of the broadcast as a word entry (must not exist in words table previously) like<br /> <b>NewsJuly2007</b> or <b>NewsAugust2007</b> without spaces !<br />";
  echo "</td>";
  echo "<td>";
  echo "<input type=text ";
  if ($Name != "")
    echo "readonly"; // don't change a group name because it is connected to words
  echo " name=Name value=\"$Name\">";
  echo "</td>";

  echo "<tr><td width=30%>Title for the massmail</td>";
  echo "<td align=left><textarea name=BroadCast_Title_ cols=80 rows=1>",$BroadCast_Title_,"</textarea></td>" ;
  echo "<tr><td>text of the mass mail (first %s, if any, will be replaced by the username at sending)</td>";
  echo "<td align=left><textarea name=BroadCast_Body_ cols=80 rows=15>",$BroadCast_Body_,"</textarea></td>" ;
  echo "<tr><td>Description (as translators will see it in words) </td>";
  echo "<td align=left><textarea name=Description cols=60 rows=5>",$Description,"</textarea></td>" ;

  echo "\n<tr><td colspan=2 align=center>";

  if ($IdBroadCast != 0)
    echo "<input type=submit name=submit value=\"update massmail\">";
  else
    echo "<input type=submit name=submit value=\"create massmail\">";

  echo "<input type=hidden name=action value=createbroadcast>";
  echo "</td>\n</table>\n";
  echo "</form>\n";
  echo "</center>";

  require_once "footer.php";
} // DisplayFormCreateBroadcast

?>
