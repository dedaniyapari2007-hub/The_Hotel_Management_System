    </div> <!-- Close admin-content -->
</div> <!-- Close admin-main -->

<script>
    // Highlight active sidebar link
    const currentLocation = location.href;
    const menuItem = document.querySelectorAll('.admin-sidebar ul li a');
    const menuLength = menuItem.length;
    for (let i = 0; i < menuLength; i++) {
        if (menuItem[i].href === currentLocation) {
            menuItem[i].className = "active";
        }
    }
</script>
</body>
</html>
