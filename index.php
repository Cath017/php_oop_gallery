<?php include("includes/header.php"); ?>

<?php

$photo = new Photo(new Database);

// ****************** Pagination ******************//
$current_page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
$items_per_page = 12;
$items_total_count = $photo->count_all();

$paginate = new Paginate($current_page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos LIMIT {$items_per_page} OFFSET {$paginate->offset()}";
$photos = $photo->find_by_query($sql);
?>

<div class="row pt-5">

    <!-- Blog Entries Column -->
    <div class="col-md-12 py-3">
        <div class="container">
            <div class="row">
                <!-- Displaying Photos/Pictures -->
                <?php
                foreach ($photos as $photo) : ?>
                    <div class="col-xs-6 col-md-3 pd-2">
                        <div class="gallery">
                            <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                                <img class="img-fluid" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <br>
            <!-- Pagination -->
            <div class="row justify-content-center pt-5">
                <ul class="pagination">
                    <?php
                    if ($paginate->page_total() > 1) {
                        if ($paginate->has_previous()) {
                            echo "<li class='previous page-item'><a class='page-link' href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                        }

                        for ($i = 1; $i <= $paginate->page_total(); $i++) {
                            if ($i == $paginate->current_page) {
                                echo "<li class='active page-item'><a class='active page-link' href='index.php?page={$i}'>{$i}</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
                            }
                        }

                        if ($paginate->has_next()) {
                            echo "<li class='next page-item'><a class='page-link' href='index.php?page={$paginate->next()}'>Next</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<?php include("includes/footer.php"); ?>