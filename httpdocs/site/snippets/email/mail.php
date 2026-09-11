<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>De Reinigingsdokter</title>
</head>
<body style="background-color: #e0e0e0;">
<table cellspacing="0" cellpadding="30" align="center"  style="height: 20px; width: 560px;  ">
    <tbody>
    <tr>
        <td style="color: #757575;"><span style=" font-size: 13px; color: #b2b2b2;"></td>
    </tr>
    </tbody>
</table>
<table class="container box" cellspacing="0" cellpadding="30" align="center" style="font-family: Helvetica, Arial, sans-serif; width: 560px; background-color: #ffffff; border-radius: 8px; box-shadow: 0px 40px 30px -25px #bdbdbd;">
    <tbody style="line-height: 20px;">
    <tr>
        <td>
            <table cellpadding="10">
                <tbody>
                <tr>
                    <td class="title" colspan="2" style="color: #000; font-size: 20px; font-weight: 700;">Hoi <?php echo $fullName ?>,</td>
                </tr>
                <tr>
                    <td colspan="2" style="color: #757575;">
                        Email: <?php echo $email ?><br/>
                        Phone : <?php echo $phone ?><br/>
                        Woonplaats : <?php echo $woonplaats ?> <br/>
                        lead : <?php echo $lead ?> <br/>

                        <?php echo $message ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>