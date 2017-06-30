<?php $ratingsFloor = floor($ratings) ?>
<?php $isEven = $ratingsFloor > 0 ? $ratings - $ratingsFloor > 0.3 : false ?>
<?php for ($i = 1; $i <= 5; $i++): ?>
    <?php if ($i <= $ratingsFloor): ?>
        <i class="fa fa-star"></i>
    <?php elseif ($isEven): ?>
        <?php $isEven = false ?>
        <i class="fa fa-star-half-full"></i>
    <?php else: ?>
        <i class="fa fa-star-o"></i>
    <?php endif; ?>
<?php endfor; ?>

<?php if (!$isStarOnly): ?>
    <span><?= $ratings > 0 ? number_format($ratings, 1) : 'Unrated' ?></span>
<?php endif; ?>