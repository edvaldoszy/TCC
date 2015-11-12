<form action="/admin/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="attach[]" multiple>
    <input type="submit" value="Send">
</form>

<?= $this->getAttribute('div_images') ?>