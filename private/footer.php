    <script>
        <?php global $_CONFIG; ?>console.log("Injecting Familine header")
        document.body.innerHTML = document.body.innerHTML + "<iframe style=\"position:fixed;left:0;right:0;top:0;border: none;width: 100%;height:32px;\" src=\"https://<?= /** @var array $_CONFIG */
            $_CONFIG["Global"]["cdn"] ?>/statusbar.php\"></iframe>";
        document.getElementsByTagName("html")[0].style.marginTop = "32px";
        document.getElementsByTagName("html")[0].style.height = "calc(100vh - 32px)";
    </script>
    <?php if (isset($_GET['q'])): ?>
    <script>
        window.addEventListener('load', () => {
            $(".flexdatalist").flexdatalist('value', "<?= strip_tags(str_replace("\"", "''", $_GET['q'])) ?>");
        });
    </script>
    <?php endif; ?>
</body>
</html>