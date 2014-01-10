<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
include_once(dirname(__FILE__) . '/classes/functions-clients.php');

$title = 'clients';
$label = '';
include_once('header.php');

if(isset($_GET['alpha'])){
    $alpha = $_GET['alpha'];
} else {
    $alpha = 'recent';
}

?>

    <script src="js/clients.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/clients-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/clients-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3>
										<i class="icon-list-alt"></i>
										Alpha
									</h3>
								</div>

                                <div class="btn-toolbar">
                                        <button class="btn alpha<?php echo ($alpha == "recent" ? " btn-primary" : "")?>" data-value="recent">Recent</button>
									    <button class="btn alpha<?php echo ($alpha == "a" ? " btn-primary" : "")?>" data-value="a">A</button>
										<button class="btn alpha<?php echo ($alpha == "b" ? " btn-primary" : "")?>" data-value="b">B</button>
										<button class="btn alpha<?php echo ($alpha == "c" ? " btn-primary" : "")?>" data-value="c">C</button>
                                        <button class="btn alpha<?php echo ($alpha == "d" ? " btn-primary" : "")?>" data-value="d">D</button>
										<button class="btn alpha<?php echo ($alpha == "e" ? " btn-primary" : "")?>" data-value="e">E</button>
										<button class="btn alpha<?php echo ($alpha == "f" ? " btn-primary" : "")?>" data-value="f">F</button>
										<button class="btn alpha<?php echo ($alpha == "g" ? " btn-primary" : "")?>" data-value="g">G</button>
										<button class="btn alpha<?php echo ($alpha == "h" ? " btn-primary" : "")?>" data-value="h">H</button>
										<button class="btn alpha<?php echo ($alpha == "i" ? " btn-primary" : "")?>" data-value="i">I</button>
										<button class="btn alpha<?php echo ($alpha == "j" ? " btn-primary" : "")?>" data-value="j">J</button>
										<button class="btn alpha<?php echo ($alpha == "k" ? " btn-primary" : "")?>" data-value="k">K</button>
										<button class="btn alpha<?php echo ($alpha == "l" ? " btn-primary" : "")?>" data-value="l">L</button>
										<button class="btn alpha<?php echo ($alpha == "m" ? " btn-primary" : "")?>" data-value="m">M</button>
										<button class="btn alpha<?php echo ($alpha == "n" ? " btn-primary" : "")?>" data-value="n">N</button>
										<button class="btn alpha<?php echo ($alpha == "o" ? " btn-primary" : "")?>" data-value="o">O</button>
										<button class="btn alpha<?php echo ($alpha == "p" ? " btn-primary" : "")?>" data-value="p">P</button>
										<button class="btn alpha<?php echo ($alpha == "q" ? " btn-primary" : "")?>" data-value="q">Q</button>
										<button class="btn alpha<?php echo ($alpha == "r" ? " btn-primary" : "")?>" data-value="r">R</button>
										<button class="btn alpha<?php echo ($alpha == "s" ? " btn-primary" : "")?>" data-value="s">S</button>
										<button class="btn alpha<?php echo ($alpha == "t" ? " btn-primary" : "")?>" data-value="t">T</button>
                                        <button class="btn alpha<?php echo ($alpha == "u" ? " btn-primary" : "")?>" data-value="u">U</button>
										<button class="btn alpha<?php echo ($alpha == "v" ? " btn-primary" : "")?>" data-value="v">V</button>
										<button class="btn alpha<?php echo ($alpha == "w" ? " btn-primary" : "")?>" data-value="w">W</button>
										<button class="btn alpha<?php echo ($alpha == "x" ? " btn-primary" : "")?>" data-value="x">X</button>
										<button class="btn alpha<?php echo ($alpha == "y" ? " btn-primary" : "")?>" data-value="y">Y</button>
										<button class="btn alpha<?php echo ($alpha == "z" ? " btn-primary" : "")?>" data-value="z">Z</button>
		                        </div>
								<div class="box-content">
                                    <?php list_clientsalpha($alpha); ?>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

<?php
include("footer.php");
?>
