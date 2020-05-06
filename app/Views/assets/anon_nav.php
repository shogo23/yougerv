<?php
    //Scss path for this view file /src/sess/partials/nav.scss
?>


<nav class="main_nav">
    <div class="nav_content">
        <div class="logo_container">
            <a href="/">YouGerv</a>
        </div>
        <div class="search_container">
            <div class="text_input">
                <form id="the_search" method="get">
                    <input type="text" name="s" class="search" placeholder="Search Videos Here" autocomplete="off" />
                    <i class="fas fa-search search-btn"></i>
                </form>
            </div>
        </div>
        <div class="links_container">
            <ul class="lg">
                <li><a href="/login"><i class="fas fa-user"></i> Login</a></li>
                <li><a href="/register"><i class="fas fa-user-plus"></i> Register</a></li>
            </ul>
            <ul class="sm">
                <li><i class="fas fa-search search-btn-toggler"></i></li>
                <li><a href="/login"><i class="fas fa-user"></i></a></li>
                <li><a href="/register"><i class="fas fa-user-plus"></i></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</nav>
<div class="search_floating">
    <div class="contents">
        <div class="text_input">
            <form id="the_search" method="get">
                <input type="text" name="s" class="search_m" placeholder="Search Videos Here" autocomplete="off" />
                <i class="fas fa-search search-btn-toggle"></i>
            </form>
        </div>
    </div>
</div>

<script>
    var toggle_sm_search = false;

    $(".search-btn-toggler").on("click", function() {
        if (!toggle_sm_search) {
            toggle_sm_search = true;
            $(".search_floating").slideDown();
        } else {
            toggle_sm_search = false;
            $(".search_floating").slideUp();
        }
    });

    $(".search-btn").on("click", function() {
        $("#the_search").submit();
    });
</script>