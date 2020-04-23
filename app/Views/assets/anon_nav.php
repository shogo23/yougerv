<nav class="main_nav">
    <div class="links_content">
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
            <ul>
                <li><a href="#"><i class="fas fa-user"></i> Login</a></li>
                <li><a href="#"><i class="fas fa-user-plus"></i> Register</a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</nav>

<script>
    $(".search-btn").on("click", function() {
        $("#the_search").submit();
    });
</script>