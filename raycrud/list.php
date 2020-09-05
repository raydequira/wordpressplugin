<?php

function raycrud () {
 
    global $wpdb;
    $msg = "";
 
	$table_name = $wpdb->prefix . 'article';

    if(isset($_GET['delete']) && isset($_GET['id'])) {
        $id = sanitize_key($_GET['id']);
        
        if (!preg_match("/^[0-9]*$/",$id))
            $msg = "error:Only numbers allowed in the ID";
        else {
            $wpdb->delete( $table_name, array( 'ID' => $id ) );
            $msg = "updated:Article deleted!";
        }
    }
 

    $rows = $wpdb->get_results(
        $wpdb->prepare("SELECT id,title,slug,content from $table_name",$msg)
    );
 
?>

 
<div>
 
    <h2>Article</h2>

    <a href="<?php echo admin_url('admin.php?page=raycrud_create'); ?>">Add New</a>
 
    <?php
    if (!empty($msg)) {
        $fmsg = explode(':',$msg);
        echo "<div class=\"{$fmsg[0]}\"><p>{$fmsg[1]}</p></div>";
    }
    ?>

    <table class='wp-list-table widefat fixed'>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Content</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($rows as $row ){
        ?>
        <tr>
            <td><?php echo $row->title ?></td>
            <td><?php echo $row->url ?></td>
            <td><?php echo $row->content ?></td>
            <td>
                <a href="<?php echo admin_url("admin.php?page=raycrud_update&id=".$row->id); ?>">Update</a> |
                <a href="<?php echo admin_url("admin.php?page=raycrud&delete&id=".$row->id); ?>"
                onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php
    }
    ?>
    </table>
</div>
<?php
}