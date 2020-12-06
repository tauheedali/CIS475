
<footer>
    <div class="container">
        <p>I used <a href="https://www.jetbrains.com/phpstorm/" target="_blank">PhpStorm</a> to create this website</p>
        <p>I used <a href="https://www.docker.com/" target="_blank">Docker and Docker Compose</a> to create my local dev server.</p>
        <p>&copy; <span id="copyright"></span> <a href="mailto:alit01@mail.buffalostate.edu">Tauheed Ali</a> | Last Modified 2020-09-10</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
new WOW().init();
let date = new Date();

$('#copyright').text(date.getFullYear());
$('a[href*="#"]').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate(
        {
            scrollTop: $($(this).attr('href')).offset().top,
        },
        500,
        'linear'
    )
});
$('.slides').slick({
    autoplay: true,
    arrows: false,
    fade: true,
});
</script>
</body>
</html>
