<?php
function raycrud_update () {
global $wpdb;
 

$id = sanitize_key($_GET['id']);
$title = sanitize_text_field($_POST['title']);
$slug = sanitize_text_field($_POST['slug']);
$content = sanitize_textarea_field($_POST['content']);
$msg = "";
 

if(isset($_POST['update'])){
 

    if (!preg_match("/^[a-zA-Z ]*$/",$title) or empty($title)) {
        $msg = "error:Only letters and white space allowed in the title";
    }   elseif(!preg_match("/^[a-zA-Z ]*$/",$slug) or empty($slug)){
        $msg = "error:Only letters and white space allowed in the slug";
    } else {
    
        $wpdb->update(
            'wp_article',
            array('title' => $title,'slug' => $slug, 'content' => $content),
            array('ID' => $id ),
            array('%s','%s','%s'), 
            array('%s') 
        );
        
        $msg = "updated:Article updated!";
    
    }
}
 

$articles = $wpdb->get_row(
    $wpdb->prepare("SELECT id,title,slug,content from wp_article where id=%d",$id)
);
 
?>
<div class="wrap">
    <h2>Update Userss</h2>
    
    <?php
    if (!empty($msg)) {
        $fmsg = explode(':',$msg);
        echo "<div class=\"{$fmsg[0]}\"><p>{$fmsg[1]}</p></div>";
    }
    ?>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=raycrud')?>">&laquo; Back to Userss list</a>
    </p>
    
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <table class='wp-list-table widefat fixed'>
        <tr>
            <th>Title</th>
            <td><input type="text" name="title" value="<?php echo $articles->title;?>"/></td>
        </tr>
        <tr>
            <th>Slug</th>
            <td><input type="text" name="slug" value="<?php echo $articles->slug;?>"/></td>
        </tr>
        <tr>
            <th>Content</th>
            <td><input type="text" name="content" value="<?php echo $articles->content;?>"/></td>
        </tr>
        </table>
        <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
    </form>
 
</div>
<?php
}