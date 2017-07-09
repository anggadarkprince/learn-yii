<?php
/* @var $this \yii\web\View view component instance */
/* @var $user \app\models\User user model instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

$this->title = 'Activation Account';
?>

<?php
$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'header-2' => 'margin-top: 0; color: #2F3133; font-size: 17px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
];
?>

<?php $fontFamily = "font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;"; ?>

<table style="<?php echo $style['email-body_inner'] ?>" align="center" width="570"
       cellpadding="0" cellspacing="0">
    <tr>
        <td style="<?php echo $fontFamily ?> <?php echo $style['email-body_cell'] ?>">
            <!-- Greeting -->
            <h1 style="<?php echo $style['header-1'] ?>">User Activation</h1>

            <!-- Info -->
            <h3 style="<?php echo $style['paragraph'] ?>">
                Hi, <?php echo $user->name ?>
            </h3>
            <p style="<?php echo $style['paragraph'] ?>">
                Please active your account by clicking button below or manual by copying
                url to address bar.
            </p>

            <!-- Action Button -->
            <table style="<?php echo $style['body_action'] ?>" align="center" width="100%"
                   cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <a href="<?php echo $urlActivation; ?>"
                           style="<?php echo $fontFamily ?> <?php echo $style['button'] ?> <?php echo $style['button--blue'] ?>"
                           class="button" target="_blank">
                            ACTIVATE MY ACCOUNT
                        </a>
                    </td>
                </tr>
            </table>
            <!-- Email Salutation -->

            <!-- Salutation -->
            <p style="<?php echo $style['paragraph'] ?>">
                With kind regards,<br>
                <span style="font-weight: bold;"><?= Yii::$app->name ?> team</span>
            </p>

            <!-- Sub Content -->
            <table style="<?php echo $style['body_sub'] ?>">
                <tr>
                    <td style="<?php echo $fontFamily ?>">
                        <p style="<?php echo $style['paragraph-sub'] ?>">
                            If you’re having trouble clicking the "Activate" button,
                            copy and paste the URL below into your web browser:
                        </p>

                        <p style="<?php echo $style['paragraph-sub'] ?>">
                            <a style="<?php echo $style['anchor'] ?>" href="<?php echo $urlActivation; ?>">
                                <?php echo $urlActivation; ?>
                            </a>
                        </p>

                        <p style="<?php echo $style['paragraph-sub'] ?>">
                            This email was intended for <?= $user->email ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>