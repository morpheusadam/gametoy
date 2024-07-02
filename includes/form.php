<form method="post" action="" class="mb-4 text-right"> <!-- Added text-right class for RTL -->
    <input type="hidden" name="gametoy_action" value="fetch_api_data">
    <div class="form-group">
        <label for="pageNum"><?php _e('Page Number', 'gametoy'); ?>:</label>
        <input type="number" id="pageNum" name="pageNum" value="<?php echo isset($_POST['pageNum']) ? intval($_POST['pageNum']) : 1; ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="pageSize"><?php _e('Page Size', 'gametoy'); ?>:</label>
        <input type="number" id="pageSize" name="pageSize" value="<?php echo isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 8; ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary"><?php _e('Fetch API Data', 'gametoy'); ?></button>
</form>