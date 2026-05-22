<?php
/**
 * Plugin Name: CF7 Custom Messages
 * Description: Adds support for custom messages in Contact Form 7 with a flexible language system.
 * Version: 1.3
 * Author: Vache Baloyan
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cf7-custom-messages
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Disable automatic paragraph creation in Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

// Hook our custom function to the wpcf7_contact_form_properties filter
add_filter('wpcf7_contact_form_properties', 'cf7cm_custom_messages', 10, 2);

function cf7cm_custom_messages($properties, $instance)
{
    $form_title = $instance->title();

    // Load saved translations
    $options = get_option('cf7cm_translations', cf7cm_default_translations());

    // Determine the language based on the form title
    if (is_array($options)) {
        foreach ($options as $language_key => $translations) {
            if (strpos($form_title, $language_key) !== false) {
                // Update the messages with the translations
                foreach ($translations as $key => $translation) {
                    if (isset($properties['messages'][$key]) && !empty($translation)) {
                        $properties['messages'][$key] = $translation;
                    }
                }
                break; // Stop after first match
            }
        }
    }

    return $properties;
}

// Default translations
function cf7cm_default_translations()
{
    return [
        'Armenian' => [
            'mail_sent_ok' => 'Շնորհակալություն ձեր հաղորդագրության համար: Այն ուղարկվել է։',
            'mail_sent_ng' => 'Ձեր հաղորդագրությունն ուղարկելիս սխալ տեղի ունեցավ: Խնդրում եմ փորձեք մի փոքր ուշ։',
            'validation_error' => 'Մեկ կամ մի քանի դաշտեր ունեն սխալ: Խնդրում ենք ստուգել և նորից փորձել:',
            'spam' => 'Ձեր հաղորդագրությունն ուղարկելիս սխալ տեղի ունեցավ: Խնդրում եմ փորձեք մի փոքր ուշ։',
            'accept_terms' => 'Դուք պետք է ընդունեք պայմաններն ու պայմանները նախքան ձեր հաղորդագրությունն ուղարկելը:',
            'invalid_required' => 'Խնդրում ենք լրացնել այս դաշտը:',
            'invalid_too_long' => 'Այս դաշտը չափազանց երկար մուտքագրված է:',
            'invalid_too_short' => 'Այս դաշտը չափազանց կարճ մուտք ունի:',
            'upload_failed' => 'Ֆայլը վերբեռնելիս անհայտ սխալ տեղի ունեցավ:',
            'upload_file_type_invalid' => 'Ձեզ չի թույլատրվում վերբեռնել այս տեսակի ֆայլեր:',
            'upload_file_too_large' => 'Վերբեռնված ֆայլը չափազանց մեծ է:',
            'upload_failed_php_error' => 'Ֆայլը վերբեռնելիս սխալ տեղի ունեցավ:',
            'invalid_date' => 'Խնդրում ենք մուտքագրել ամսաթիվ՝ YYYY-MM-DD ձևաչափով:',
            'date_too_early' => 'Այս դաշտը շատ վաղ ժամկետ ունի:',
            'date_too_late' => 'Այս դաշտը չափազանց ուշ ժամկետ ունի:',
            'invalid_number' => 'Խնդրում ենք մուտքագրել թիվ:',
            'number_too_small' => 'Այս դաշտը չափազանց փոքր թիվ ունի:',
            'number_too_large' => 'Այս դաշտը չափազանց մեծ թիվ ունի:',
            'quiz_answer_not_correct' => 'Վիկտորինայի պատասխանը սխալ է։',
            'invalid_email' => 'Խնդրում ենք մուտքագրել էլփոստի հասցե:',
            'invalid_url' => 'Խնդրում ենք մուտքագրել URL:',
            'invalid_tel' => 'Խնդրում ենք մուտքագրել հեռախոսահամար:',
        ],
        'Russian' => [
            'mail_sent_ok' => 'Спасибо за ваше сообщение. Оно было отправлено.',
            'mail_sent_ng' => 'При отправке вашего сообщения произошла ошибка. Пожалуйста, попробуйте позже.',
            'validation_error' => 'Одно или несколько полей содержат ошибку. Пожалуйста, проверьте и попробуйте снова.',
            'spam' => 'При отправке вашего сообщения произошла ошибка. Пожалуйста, попробуйте позже.',
            'accept_terms' => 'Вы должны принять условия и положения перед отправкой вашего сообщения.',
            'invalid_required' => 'Пожалуйста, заполните это поле.',
            'invalid_too_long' => 'Это поле содержит слишком длинный ввод.',
            'invalid_too_short' => 'Это поле содержит слишком короткий ввод.',
            'upload_failed' => 'При загрузке файла произошла неизвестная ошибка.',
            'upload_file_type_invalid' => 'Вам не разрешено загружать файлы этого типа.',
            'upload_file_too_large' => 'Загруженный файл слишком большой.',
            'upload_failed_php_error' => 'При загрузке файла произошла ошибка.',
            'invalid_date' => 'Пожалуйста, введите дату в формате ГГГГ-ММ-ДД.',
            'date_too_early' => 'Это поле содержит слишком раннюю дату.',
            'date_too_late' => 'Это поле содержит слишком позднюю дату.',
            'invalid_number' => 'Пожалуйста, введите число.',
            'number_too_small' => 'Это поле содержит слишком маленькое число.',
            'number_too_large' => 'Это поле содержит слишком большое число.',
            'quiz_answer_not_correct' => 'Ответ на викторину неверный.',
            'invalid_email' => 'Пожалуйста, введите адрес электронной почты.',
            'invalid_url' => 'Пожалуйста, введите URL.',
            'invalid_tel' => 'Пожалуйста, введите номер телефона.',
        ],
        'English' => [
            'mail_sent_ok' => 'Thank you for your message. It has been sent.',
            'mail_sent_ng' => 'There was an error sending your message. Please try again later.',
            'validation_error' => 'One or more fields have an error. Please check and try again.',
            'spam' => 'There was an error sending your message. Please try again later.',
            'accept_terms' => 'You must accept the terms and conditions before sending your message.',
            'invalid_required' => 'Please fill out this field.',
            'invalid_too_long' => 'This field has a too long input.',
            'invalid_too_short' => 'This field has a too short input.',
            'upload_failed' => 'There was an unknown error uploading the file.',
            'upload_file_type_invalid' => 'You are not allowed to upload files of this type.',
            'upload_file_too_large' => 'The uploaded file is too large.',
            'upload_failed_php_error' => 'There was an error uploading the file.',
            'invalid_date' => 'Please enter a date in YYYY-MM-DD format.',
            'date_too_early' => 'This field has a date too early.',
            'date_too_late' => 'This field has a date too late.',
            'invalid_number' => 'Please enter a number.',
            'number_too_small' => 'This field has a number that is too small.',
            'number_too_large' => 'This field has a number that is too large.',
            'quiz_answer_not_correct' => 'The quiz answer is incorrect.',
            'invalid_email' => 'Please enter an email address.',
            'invalid_url' => 'Please enter a URL.',
            'invalid_tel' => 'Please enter a telephone number.',
        ],
    ];
}

// Set default options on plugin activation
function cf7cm_activate()
{
    $default_translations = cf7cm_default_translations();
    if (!get_option('cf7cm_translations')) {
        update_option('cf7cm_translations', $default_translations);
    }
}
register_activation_hook(__FILE__, 'cf7cm_activate');

// Admin menu for custom messages settings
add_action('admin_menu', 'cf7cm_create_menu');

function cf7cm_create_menu()
{
    add_options_page(
        'CF7 Custom Messages',
        'CF7 Custom Messages',
        'manage_options',
        'cf7-custom-messages',
        'cf7cm_settings_page'
    );
    add_action('admin_init', 'cf7cm_register_settings');
}

function cf7cm_register_settings()
{
    register_setting('cf7cm_settings_group', 'cf7cm_translations');
}

function cf7cm_settings_page() {
    $options = get_option('cf7cm_translations');
    if (!is_array($options)) {
        $options = cf7cm_default_translations();
    }
    ?>
    <div class="wrap">
        <h1>CF7 Custom Messages</h1>
        <form method="post" action="options.php">
            <?php settings_fields('cf7cm_settings_group'); ?>
            <?php do_settings_sections('cf7cm_settings_group'); ?>
            <div id="tabs">
                <ul>
                    <?php foreach ($options as $language => $messages) { ?>
                        <li>
                            <a href="#<?php echo esc_attr($language); ?>"><?php echo esc_html($language); ?></a>
                            <?php if ($language !== 'default') { ?>
                                <button type="button" class="remove-language-tab">x</button>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php foreach ($options as $language => $messages) { ?>
                    <div id="<?php echo esc_attr($language); ?>" class="translation-group">
                        <fieldset>
                            <legend>You can edit messages used in various situations here.</legend>
                            <?php foreach ($messages as $key => $translation) { ?>
                                <p class="description">
                                    <label for="<?php echo esc_attr($language . '-' . $key); ?>"><?php echo esc_html(ucwords(str_replace('_', ' ', $key))); ?><br>
                                    <input type="text" id="<?php echo esc_attr($language . '-' . $key); ?>" name="cf7cm_translations[<?php echo esc_attr($language); ?>][<?php echo esc_attr($key); ?>]" class="large-text" size="70" value="<?php echo esc_attr($translation); ?>"></label>
                                </p>
                            <?php } ?>
                        </fieldset>
                    </div>
                <?php } ?>
            </div>
            <button type="button" id="add-language">Add Language</button>
            <?php submit_button(); ?>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    jQuery(document).ready(function($) {
        $("#tabs").tabs();

        $('#add-language').insertAfter($('#tabs ul li:last-child'));

        $('#add-language').on('click', function() {
            const language = prompt('Enter the new language:');
            if (language) {
                const newTab = `
                <li><a href="#${language}">${language}</a> <button class="remove-language-tab">x</button></li>
                `;
                const newContent = `
                <div id="${language}">
                    <fieldset>
                        <legend>You can edit messages used in various situations here. For details, see <a href="https://contactform7.com/editing-messages/">Editing messages</a>.</legend>
                        <p class="description">
                            <label for="${language}-mail-sent-ok">Sender's message was sent successfully<br>
                            <input type="text" id="${language}-mail-sent-ok" name="cf7cm_translations[${language}][mail_sent_ok]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-mail-sent-ng">Sender's message failed to send<br>
                            <input type="text" id="${language}-mail-sent-ng" name="cf7cm_translations[${language}][mail_sent_ng]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-validation-error">Validation errors occurred<br>
                            <input type="text" id="${language}-validation-error" name="cf7cm_translations[${language}][validation_error]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-spam">Submission was referred to as spam<br>
                            <input type="text" id="${language}-spam" name="cf7cm_translations[${language}][spam]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-accept-terms">There are terms that the sender must accept<br>
                            <input type="text" id="${language}-accept-terms" name="cf7cm_translations[${language}][accept_terms]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-required">There is a field that the sender must fill in<br>
                            <input type="text" id="${language}-invalid-required" name="cf7cm_translations[${language}][invalid_required]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-too-long">There is a field with input that is longer than the maximum allowed length<br>
                            <input type="text" id="${language}-invalid-too-long" name="cf7cm_translations[${language}][invalid_too_long]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-too-short">There is a field with input that is shorter than the minimum allowed length<br>
                            <input type="text" id="${language}-invalid-too-short" name="cf7cm_translations[${language}][invalid_too_short]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-upload-failed">Uploading a file fails for any reason<br>
                            <input type="text" id="${language}-upload-failed" name="cf7cm_translations[${language}][upload_failed]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-upload-file-type-invalid">Uploaded file is not allowed for file type<br>
                            <input type="text" id="${language}-upload-file-type-invalid" name="cf7cm_translations[${language}][upload_file_type_invalid]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-upload-file-too-large">Uploaded file is too large<br>
                            <input type="text" id="${language}-upload-file-too-large" name="cf7cm_translations[${language}][upload_file_too_large]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-upload-failed-php-error">Uploading a file fails for PHP error<br>
                            <input type="text" id="${language}-upload-failed-php-error" name="cf7cm_translations[${language}][upload_failed_php_error]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-date">Date format that the sender entered is invalid<br>
                            <input type="text" id="${language}-invalid-date" name="cf7cm_translations[${language}][invalid_date]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-date-too-early">Date is earlier than minimum limit<br>
                            <input type="text" id="${language}-date-too-early" name="cf7cm_translations[${language}][date_too_early]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-date-too-late">Date is later than maximum limit<br>
                            <input type="text" id="${language}-date-too-late" name="cf7cm_translations[${language}][date_too_late]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-number">Number format that the sender entered is invalid<br>
                            <input type="text" id="${language}-invalid-number" name="cf7cm_translations[${language}][invalid_number]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-number-too-small">Number is smaller than minimum limit<br>
                            <input type="text" id="${language}-number-too-small" name="cf7cm_translations[${language}][number_too_small]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-number-too-large">Number is larger than maximum limit<br>
                            <input type="text" id="${language}-number-too-large" name="cf7cm_translations[${language}][number_too_large]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-quiz-answer-not-correct">Sender does not enter the correct answer to the quiz<br>
                            <input type="text" id="${language}-quiz-answer-not-correct" name="cf7cm_translations[${language}][quiz_answer_not_correct]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-email">Email address that the sender entered is invalid<br>
                            <input type="text" id="${language}-invalid-email" name="cf7cm_translations[${language}][invalid_email]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-url">URL that the sender entered is invalid<br>
                            <input type="text" id="${language}-invalid-url" name="cf7cm_translations[${language}][invalid_url]" class="large-text" size="70" value=""></label>
                        </p>
                        <p class="description">
                            <label for="${language}-invalid-tel">Telephone number that the sender entered is invalid<br>
                            <input type="text" id="${language}-invalid-tel" name="cf7cm_translations[${language}][invalid_tel]" class="large-text" size="70" value=""></label>
                        </p>
                        <!-- Add more fields as needed -->
                    </fieldset>
                </div>
                `;

                $('#tabs ul').append(newTab);
                $('#tabs').append(newContent);
                $('#tabs').tabs('refresh');
            }
        });

        $(document).on('click', '.remove-language-tab', function() {
            const panelId = $(this).closest('li').remove().attr('aria-controls');
            $('#' + panelId).remove();
            $('#tabs').tabs('refresh');
        });
    });
</script>
<style>
/* Tab Styles */
#tabs {
    font-family: Arial, sans-serif;
}

#tabs ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    border-bottom: 1px solid #ccc;
}

#tabs ul li {
    display: inline-block;
    margin-right: 10px;
    margin-bottom: 0;
}

#tabs ul li a {
    display: inline-block;
    padding: 10px 25px 10px 10px; /* Adjust padding to accommodate the remove button */
    text-decoration: none;
    color: #333;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    position: relative;
}

#tabs ul li a:hover {
    background-color: #e9e9e9;
}

#tabs ul li.ui-tabs-active a {
    background-color: #303843;
    color: #fff;
    border-bottom-color: transparent;
    border-color: #303843;
}
#tabs ul li a:focus{
    box-shadow: none;
    outline: none;
}
#tabs ul li a .remove-language-tab {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    font-size: 16px;
    background: none;
    border: none;
    padding: 0;
}

#tabs ul li a .remove-language-tab:hover {
    color: #ff3333;
}
#add-language{
    padding: 10px 15px;
    background: #fff;
    border: 1px solid #555;
    border-radius: 35px;
    color: #000;
    font-size: 15px;
    text-transform: capitalize;
}
</style>
    <?php
}

