<?php

function raycrud_create() {
    if (isset($_POST['insert'])) {

        $title = sanitize_text_field($_POST['title']);
        $slug = sanitize_text_field($_POST['slug']);
        $content = sanitize_textarea_field($_POST['content']);
        //sanitize_email
        $msg = "";

        if (!preg_match("/^[a-zA-Z ]*$/",$title) or empty($title)) {
            $msg = "error:Only letters and white space allowed in the title";
        }   elseif(!preg_match("/^[a-zA-Z ]*$/",$slug) or empty($slug)){
            $msg = "error:Only letters and white space allowed in the slug";
        } else {
            global $wpdb;
            
            $duplicate_check = $wpdb->get_var(
                    $wpdb->prepare( "SELECT count(*) FROM wp_article WHERE title = %d", $title )
                );
            if ($duplicate_check == 0) {
                $wpdb->insert(
                    'wp_article', 
                    array('title' => $title, 'slug' => $slug, 'content' => $content), 
                    array('%s', '%s', '%s') 
                );
                echo "nag insert";
                $title = "";
                $slug = "";
                $content = "";
                $msg = "updated:Article saved";
            } else {
                $msg = "error:Duplicated Title, try another";
            }
        }
    }
?>

<div class="wrap">
    <h2>Add New Users</h2>
    <?php
        if (!empty($msg)) {
            $fmsg = explode(':',$msg);
            echo "<div class=\"{$fmsg[0]}\"><p>{$fmsg[1]}</p></div>";
        }
    ?>
    <p>
        <a href="<?php echo admin_url('admin.php?page=raycrud')?>">&laquo; Back to Userss list</a>
    </p>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
        <table class='wp-list-table widefat fixed'>
            <tr>
                <th>Title</th>
                <td><input type="text" name="title" value="<?php echo $title;?>"/></td>
            </tr>
            <tr>
                <th>Slug</th>
                <td><input type="text" name="slug" value="<?php echo $slug;?>"/></td>
            </tr>
            <tr>
                <th>Content</th>
                <td><input type="text" name="content" value="<?php echo $content;?>"/></td>
            </tr>
        </table>
        <input type="submit" name="insert" value="Save" class="button">
    </form>
</div>
<?php
}