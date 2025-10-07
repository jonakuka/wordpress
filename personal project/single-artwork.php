<?php
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        $current_bid = get_post_meta(get_the_ID(), 'current_bid', true);
        $auction_end = get_post_meta(get_the_ID(), 'auction_end', true);
        $highest_bidder = get_post_meta(get_the_ID(), 'highest_bidder', true);
        if (!$current_bid) $current_bid = 0;
        if (!$auction_end) $auction_end = strtotime('+1 day');
        $is_ended = time() > $auction_end;
        ?>
        <main>
            <div class="artwork">
                <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
                <div><strong>Auction ends:</strong> <span id="auction-end"><?php echo date('Y-m-d H:i:s', $auction_end); ?></span></div>
                <div><strong>Current highest bid:</strong> $<?php echo esc_html($current_bid); ?></div>
                <div><strong>Highest bidder:</strong> <?php echo $highest_bidder ? esc_html($highest_bidder) : 'None'; ?></div>
                <?php if (!$is_ended) : ?>
                    <?php if (is_user_logged_in()) : ?>
                        <form method="post">
                            <input type="number" name="bid_amount" min="<?php echo $current_bid + 1; ?>" required placeholder="Your bid ($)">
                            <button type="submit" name="place_bid">Place Bid</button>
                        </form>
                        <?php
                        if (isset($_POST['place_bid'])) {
                            $bid = floatval($_POST['bid_amount']);
                            if ($bid > $current_bid) {
                                update_post_meta(get_the_ID(), 'current_bid', $bid);
                                update_post_meta(get_the_ID(), 'highest_bidder', wp_get_current_user()->user_login);
                                echo '<div style="color:green;">Your bid was placed!</div>';
                                // Optionally, send email notifications here
                                echo '<meta http-equiv="refresh" content="1">';
                            } else {
                                echo '<div style="color:red;">Bid must be higher than current bid.</div>';
                            }
                        }
                        ?>
                    <?php else : ?>
                        <div>Please <a href="<?php echo wp_login_url(get_permalink()); ?>">log in</a> to place a bid.</div>
                    <?php endif; ?>
                <?php else : ?>
                    <div style="color:gray;">Auction ended.</div>
                <?php endif; ?>
            </div>
            <script>
            // Simple countdown timer
            const end = new Date(document.getElementById('auction-end').textContent).getTime();
            const timer = setInterval(function() {
                const now = new Date().getTime();
                const dist = end - now;
                if (dist > 0) {
                    const h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((dist % (1000 * 60)) / 1000);
                    document.getElementById('auction-end').nextSibling.textContent = ` (Time left: ${h}h ${m}m ${s}s)`;
                } else {
                    clearInterval(timer);
                }
            }, 1000);
            </script>
        </main>
        <?php
    endwhile;
endif;
get_footer();
