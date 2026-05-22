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