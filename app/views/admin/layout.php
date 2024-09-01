<?php

include  ROOT.'app/views/admin/header.php';
include  ROOT.'app/views/admin/sidebar.php';

echo '<div class="content" id="admin_content">';

include  ROOT.'app/views/admin/'.$params['draw'].'.php';

echo '</div>';

include  ROOT.'app/views/admin/footer.php';