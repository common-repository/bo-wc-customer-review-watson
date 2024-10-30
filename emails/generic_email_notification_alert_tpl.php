<?php
/**
 * Created by PhpStorm.
 * User: Renaud Hamelin
 * Date: 12/02/2019
 * Time: 17:34
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?php _e('Tone','bo-customer-review-watson');?>CUSTOMER PRODUCT REVIEW - TONE ANALYZER RESULTS - ALERT</title>
    <style type="text/css">
        body {
            width: 100% !important;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        body {
            -webkit-text-size-adjust: none;
        }

        /* Prevent Webkit platforms from changing default text sizes. */
        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table td {
            border-collapse: collapse;
        }

        #backgroundTable {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        body, #backgroundTable {
            background-color: #FAFAFA;
        }

        #templateContainer {
            border: 1px solid #DDDDDD;
        }

        h1, .h1 {
            color: #202020;
            display: block;
            font-family: Arial;
            font-size: 34px;
            font-weight: bold;
            line-height: 100%;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            text-align: center;
        }

        h2, .h2 {
            color: #202020;
            display: block;
            font-family: Arial;
            font-size: 30px;
            font-weight: bold;
            line-height: 100%;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            text-align: center;
            opacity: 0.7;
        }

        h3, .h3 {
            color: #202020;
            display: block;
            font-family: Arial;
            font-size: 26px;
            font-weight: bold;
            line-height: 100%;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            text-align: center;
            opacity: 0.7;
        }

        h4, .h4 {
            color: #202020;
            display: block;
            font-family: Arial;
            font-size: 22px;
            font-weight: bold;
            line-height: 100%;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            text-align: center;
            opacity: 0.7;
        }

        #templateContainer, .bodyContent {
            background-color: #FFFFFF;
        }

        .bodyContent div {
            color: #505050;
            font-family: Arial;
            font-size: 14px;
            line-height: 150%;
            text-align: left;
        }

        .bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */
        .bodyContent div a .yshortcuts /* Yahoo! Mail Override */
        {
            color: #336699;
            font-weight: normal;
            text-decoration: underline;
        }

        .bodyContent img {
            display: inline;
            height: auto;
        }

        #templateFooter {
            background-color: #FFFFFF;
            border-top: 0;
        }

        .footerContent div {
            color: #707070;
            font-family: Arial;
            font-size: 12px;
            line-height: 125%;
            text-align: left;
        }

        .footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */
        .footerContent div a .yshortcuts /* Yahoo! Mail Override */
        {
            color: #336699;
            font-weight: normal;
            text-decoration: underline;
        }

        .footerContent img {
            display: inline;
        }

        #utility div {
            text-align: center;
        }
    </style>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                    <tr>
                        <td align="center" valign="top" style="padding: 10px;">
                            <h1 class="h1">*|SITENAME|*</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                    <tr>
                        <td valign="top" class="preheaderContent"></td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                <tr>
                                    <td valign="top" class="bodyContent">
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top">
                                                    <div>
                                                        <h2 class="h2"><?php _e('CUSTOMER PRODUCT REVIEW - TONE ANALYZER RESULTS - ALERT','bo-customer-review-watson');?></h2>
                                                        <h4 class="h4"><?php _e('A review has been posted on the product','bo-customer-review-watson');?> "*|PRODUCTNAME|*"
                                                            <br><?php _e('that needs your moderation','bo-customer-review-watson');?>.</h4>
                                                        <h5><?php _e('This review has been analyzed by the plugin','bo-customer-review-watson');?> "*|BODAI_PLUGINNAME|*", <?php _e('that detected that some texts where fitting to your alert criterias','bo-customer-review-watson');?>.</h5>
                                                        <br/>
                                                        <h4><?php _e('Comment text submited:','bo-customer-review-watson');?></h4>
                                                        <div style="background: #EEEEEE; border: solid 1px #CCCCCC; padding: 10px; margin: 15px 0;">*|COMMENTTXT|*</div>

                                                        <h4><?php _e('Sentences with warning:','bo-customer-review-watson');?></h4>
                                                        <p>*|SENTENCES|*</p>
                                                        <h4><?php _e('Warning on Document level:','bo-customer-review-watson');?></h4>
                                                        <p><?php _e('(Mainly used in case there is only one sentence in the review\'s text)','bo-customer-review-watson');?></p>
                                                        <p>*|DOCSALERTS|*</p>
                                                        <br/>
                                                        <br/>
                                                        <h4><?php _e('Please moderate this customer review:','bo-customer-review-watson');?></h4>
                                                        <br><strong><?php _e('Link to edit the comment:','bo-customer-review-watson');?></strong>
                                                        <p><a href="*|LINKEDITCOMMENT|*">*|LINKEDITCOMMENT|*</a></p>
                                                        <strong><?php _e('Link to the product front page:','bo-customer-review-watson');?></strong>
                                                        <p><a href="*|LINKPRODUCT|*">*|LINKPRODUCT|*</a></p>
                                                        <strong><?php _e('To reply: open the product edit form > find comments to reply at the bottom:','bo-customer-review-watson');?></strong>
                                                        <p><a href="*|LINKPRODUCTFORM|*">*|LINKPRODUCTFORM|*</a></p>
                                                        <br/>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                    <tr>
                        <td align="center" valign="top">
                            <?php _e('Email generated by','bo-customer-review-watson');?> "*|BODAI_PLUGINNAME|*". <?php _e('Sent to all administrator users','bo-customer-review-watson');?>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>
</body>
</html>
