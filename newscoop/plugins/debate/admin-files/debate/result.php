<?php
camp_load_translation_strings("plugin_poll");

// Check permissions
if (!$g_user->hasPermission('plugin_poll')) {
    camp_html_display_error(getGS('You do not have the right to manage polls.'));
    exit;
}

$f_poll_nr = Input::Get('f_poll_nr', 'int');
$f_fk_language_id = Input::Get('f_fk_language_id', 'int');

$f_nr_answer = Input::Get('f_nr_answer', 'int');

$poll = new Debate($f_fk_language_id, $f_poll_nr);

$format = '%.2f';

$display[] = $poll;

foreach($poll->getTranslations() as $translation) {
    if ($translation->getLanguageId() != $poll->getLanguageId()) {
        $display[] = $translation;
    }
}

echo camp_html_breadcrumbs(array(
    array(getGS('Plugins'), $Campsite['WEBSITE_URL'] . '/admin/plugins/manage.php'),
    array(getGS('Debates'), $Campsite['WEBSITE_URL'] . '/admin/debate/index.php'),
    array(getGS('Result'), ''),
));
?>
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="1" class="action_buttons" style="padding-top: 5px;">
<TR>
    <TD><A HREF="index.php"><IMG SRC="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/left_arrow.png" BORDER="0"></A></TD>
    <TD><A HREF="index.php"><B><?php  putGS("Debate List"); ?></B></A></TD>
    <TD style="padding-left: 20px;"><A HREF="edit.php" ><IMG SRC="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/add.png" BORDER="0"></A></TD>
    <TD><A HREF="edit.php" ><B><?php  putGS("Add new Debate"); ?></B></A></TD>
</tr>
</TABLE>
<p>
<?php foreach ($display as $translation) : $color = 0; ?>
    <TABLE BORDER="0" CELLSPACING="1" CELLPADDING="3" class="table_list" style="padding-top: 5px;">
        <TR class="table_list_header">
            <TD ALIGN="LEFT" VALIGN="TOP"><?php  putGS("Title"); ?></TD>
            <TD ALIGN="center" VALIGN="TOP"><?php  putGS("Votes"); ?></TD>
            <TD ALIGN="center" VALIGN="TOP"><?php  putGS("Percentage this language"); ?></TD>
            <TD ALIGN="center" VALIGN="TOP"><?php  putGS("Percentage all languages"); ?></TD>
        </TR>
        <tr>
            <th><?php p($translation->getProperty('title')); ?> (<?php p($translation->getLanguageName()); ?>)</th>
            <td align="CENTER"><?php p($translation->getProperty('nr_of_votes')); ?> / <?php p($translation->getProperty('nr_of_votes_overall')); ?></td>
            <td align="LEFT">
                <img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarlinks.png" width="1" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbar.png" width="<?php p($translation->getProperty('percentage_of_votes_overall')); ?>" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarrechts.png" width="1" height="9" class="IMG_norm">
                <?php printf($format, $translation->getProperty('percentage_of_votes_overall')); ?>%
            </td>
            <th> </th>
        </tr>
        <?php
        foreach ($translation->getAnswers() as $answer) {
            if ($color) {
                $rowClass = "list_row_even";
            } else {
                $rowClass = "list_row_odd";
            }
            $color = !$color;
            ?>
            <tr class="<?php p($rowClass); ?>" >
              <td width="400"><?php p($answer->getProperty('answer')); ?></td>
              <td width="50" ALIGN="center"><?php p($answer->getProperty('nr_of_votes')); ?></td>
              <td width="200">
                <img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarlinks.png" width="1" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbar.png" width="<?php p($answer->getProperty('percentage')); ?>" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarrechts.png" width="1" height="9" class="IMG_norm">
                <?php printf($format, $answer->getProperty('percentage')); ?>%
              </td>
              <td width="200">
                <img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarlinks.png" width="1" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbar.png" width="<?php p($answer->getProperty('percentage_overall')); ?>" height="9" class="IMG_norm"><img src="<?php echo $Campsite["ADMIN_IMAGE_BASE_URL"]; ?>/mainbarrechts.png" width="1" height="9" class="IMG_norm">
                <?php printf($format, $answer->getProperty('percentage_overall')); ?>%
              </td>
            </tr>
            <?php
        }
    ?>
    </table>
    <p>
<?php endforeach ?>
