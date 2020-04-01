<?php echo form_open('config/save_mpesa/', array('id' => 'mpesa_config_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<div id="config_wrapper">
    <fieldset id="config_info">
        <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
        <ul id="mpesa_error_message_box" class="error_message_box"></ul>

        <div class="form-group form-group-sm">
            <?php echo form_label($this->lang->line('config_mpesa_till_number'), 'mpesa_till_number', array('class' => 'control-label col-xs-2')); ?>
            <div class='col-xs-2'>
                <?php echo form_input(array(
                    'name' => 'mpesa_till_number',
                    'id' => 'mpesa_till_number',
                    'class' => 'form-control input-sm',
                    'value' => $this->config->item('mpesa_till_number'),
                    'placeholder' => 'XXXXXX')); ?>
            </div>
        </div>

        <?php echo form_submit(array(
            'name' => 'submit_mpesa',
            'id' => 'submit_mpesa',
            'value' => $this->lang->line('common_submit'),
            'class' => 'btn btn-primary btn-sm pull-right')); ?>

    </fieldset>
</div>
<?php echo form_close(); ?>

<?php echo form_open('mpesa/test/', array('id' => 'mpesa_test_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<hr style="margin: 40px 0 5px 0">
<div class="text-center">Test Mpesa integration</div>
<ul id="mpesa_test_error_message_box" class="error_message_box"></ul>

<div class="form-group form-group-sm">
    <?php echo form_label($this->lang->line('config_mpesa_test_phone_number'), 'mpesa_test_phone_number', array('class' => 'control-label col-xs-2')); ?>
    <div class='col-xs-2'>
        <?php echo form_input(array(
            'name' => 'mpesa_test_phone_number',
            'id' => 'mpesa_test_phone_number',
            'class' => 'form-control input-sm',
            'value' => $this->config->item('mpesa_test_phone_number'),
            'placeholder' => '07XXXXXXXX')); ?>
    </div>
</div>

<?php echo form_submit(array(
    'name' => 'mpesa_test',
    'id' => 'mpesa_test',
    'value' => $this->lang->line('common_submit'),
    'class' => 'btn btn-primary btn-sm pull-right')); ?>
<?php echo form_close(); ?>


<script>
    $(document).ready(() => {
        $.validator.addMethod(
            'regex',
            function (input, inputEl, pattern) {
                const regExp = new RegExp(pattern);
                return this.optional(inputEl) || regExp.test(input)
            },
            "Invalid pattern."
        );

        $('#mpesa_config_form').validate($.extend(form_support.handler, {
            errorLabelContainer: "#mpesa_error_message_box",
            rules: {
                mpesa_till_number: {
                    required: true,
                    regex: '^[0-9]{6}$'
                }
            },
            messages: {
                mpesa_till_number: {
                    required: "<?php echo $this->lang->line('config_mpesa_till_number_required'); ?>",
                    regex: "<?php echo $this->lang->line('config_mpesa_till_number_invalid'); ?>"
                }
            }
        }));

        $('#mpesa_test_form').validate($.extend(form_support.handler, {
            errorLabelContainer: '#mpesa_test_error_message_box',
            rules: {
                mpesa_test_phone_number: {
                    required: true,
                    regex: '^0([0-9]){9}$'
                }
            },
            messages: {
                mpesa_test_phone_number: {
                    required: "<?php echo $this->lang->line('config_mpesa_test_phone_number_required'); ?>",
                    regex: "The phone number provided is invalid"
                }
            }
        }))
    });
</script>
