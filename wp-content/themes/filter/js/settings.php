<?php
class ControlPanel {
/* Устанавливаем значения по умолчанию */
    var $default_settings = array(
        'phone' => '+7(000)000-00-00',
        'email' => 'mail@mail.ru',
        'date' => 'Пн-Сб : 10:00-20:00',
        'address' => 'г. Санкт-Петербург'
    );
    var $options;

    function ControlPanel() {
        add_action('admin_menu', array(&$this, 'add_menu'));
        if (!is_array(get_option('themadmin')))
            add_option('themadmin', $this->default_settings);
        $this->options = get_option('themadmin');
    }

    function add_menu() {
        add_theme_page('WP Theme Options', 'Опции темы', 8, "themadmin", array(&$this, 'optionsmenu'));
    }

    /* Сохраняем значения формы с настройками */
    function optionsmenu() {
        if ($_POST['ss_action'] == 'save') {
            $this->options["phone"] = $_POST['cp_phone'];
            $this->options["email"] = $_POST['cp_email'];
            $this->options["date"] = $_POST['cp_date'];
            $this->options["address"] = $_POST['cp_address'];
            update_option('themadmin', $this->options);
            echo '
                <div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 400px; margin-left: 17px; margin-top: 17px;">
                <p>Ваши изменения <strong>сохранены</strong>.</p>
                </div>';
        }
        /* Создаем форму для настроек */
        echo '<form action="" method="post" class="themeform">';
        echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';

        print '
            <div class="cptab">
                <br /> 
                <h3>Контакты</h3>
                <p>
                    <input placeholder="Телефон" style="width:300px;" name="cp_phone" id="cp_phone" value="'.$this->options["phone"].'">
                    <label> - Телефон</label>
                </p>
                <p>
                    <input placeholder="Email" style="width:300px;" name="cp_email" id="cp_email" value="'.$this->options["email"].'">
                    <label> - Email</label>
                </p>
                <p>
                    <input placeholder="Дата" style="width:300px;" name="cp_date" id="cp_date" value="'.$this->options["date"].'">
                    <label> - Дата</label>
                </p>
                <p>
                    <input placeholder="Адрес" style="width:300px;" name="cp_address" id="cp_address" value="'.$this->options["address"].'">
                    <label> - Адрес</label>
                </p>
            </div>
            <br />';
        echo '<input type="submit" value="Сохранить" name="cp_save" class="dochanges" />';
        echo '</form>';
    }
}

$cpanel = new ControlPanel();
$info = get_option('themadmin');
?>