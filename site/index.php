<?php require_once('partials/header.php'); ?>
<section id="header">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="p-5">
                    <h2 class="wow fadeInUp">This is my homepage</h2>
                    <h4 class="wow fadeIn">There are many like it, but this one is mine.</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<main id="main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title"><?= $page; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <img class="w-100" src="https://media-exp1.licdn.com/dms/image/C4E03AQEQlWftB1QGSQ/profile-displayphoto-shrink_400_400/0?e=1605139200&v=beta&t=wBjKqjSaS1qheu5TuM6xu_yCPpCbDusgG_xdUAED1HM" alt="LinkedIn Profile Pic"/>
                <hr/>
                <div class="text-center">
                    <p class="text-bold"><?= $author; ?></p>
                </div>
            </div>
            <div class="col-9">
                <p>As a developer, I'm always looking to improve my skills. I'm currently attending Buffalo State College
                    pursuing a Bachelor's Degree in <i>Computer Information Systems.</i></p>
                <p>For this website, I'm using <?= $editor; ?> to edit my PHP code. <br/> While developing this site locally, I'm using a LAMPP stack configured on <?= $server; ?>. I'll be hosting this project on GitHub soon if anyone is curious on
                    how to use Docker to configure a server.
                </p>
            </div>
        </div>
    </div>
</main>
<section id="projects">
    <div class="container">
        <h2>What I'm Working On</h2>
        <hr/>
        <?php displayAssignments(); ?>
    </div>
</section>
<?php require_once('partials/footer.php'); ?>

