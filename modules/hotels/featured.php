<section class="eg-home-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Rest well</p>
                <h2>Stays for every kind of trip</h2></div>
            <a class="eg-text-link" href="hotels.php">See all hotels <i class="fa fa-arrow-right"></i></a></div>
        <div class="eg-card-grid"><?php foreach ($hotels as $hotel): ?>
                <article class="eg-stay-card"><a class="eg-stay-card__image"
                                                 href="hotel.php?hotel_id=<?= (int)$hotel['hotel_id'] ?>"><img
                            src="admin/hotel/<?= rawurlencode($hotel['hotel_image']) ?>"
                            alt="<?= e($hotel['hotel_name']) ?>" loading="lazy"></a>
                <div class="eg-stay-card__body"><span class="eg-trip-card__meta"><i
                                class="fa fa-map-marker"></i> <?= e($hotel['place_name']) ?></span>
                    <h3>
                        <a href="hotel.php?hotel_id=<?= (int)$hotel['hotel_id'] ?>"><?= e($hotel['hotel_name']) ?></a>
                    </h3>
                    <div class="eg-stay-card__foot">
                        <span><small>From</small><strong>Rs. <?= number_format((float)$hotel['hotel_price']) ?></strong></span><a
                                href="login.php?next=<?= rawurlencode('user/booking.php?type=hotel&id=' . (int)$hotel['hotel_id']) ?>">Book
                            stay</a></div>
                </div></article><?php endforeach; ?></div>
    </div>
</section>
