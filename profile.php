<?php
include(__DIR__.'/admin/sistema.class.php');
$app= new Sistema();
if(!$app->checkRol('Socio')){
    header("Location: login.php");
}
$app->connect();
include(__DIR__.'/header_profile.php');
$sql="SELECT s.nombre, s.primer_apellido, s.segundo_apellido FROM socio s JOIN usuario u USING (id_usuario) WHERE s.id_usuario = :id_usuario;";
$stmt=$app->conn->prepare($sql);
$id_usuario = $_SESSION['id_usuario'];
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$socio=$stmt->fetchAll();
echo "<h1 style='color: white;'>Bienvenido ". $socio[0]['nombre'] ." ".$socio[0]['primer_apellido'] ." ". $socio[0]['segundo_apellido']. "</h1>";
?>
<section>
													<header class="major">
														<h2>Subheading</h2>
													</header>
													<p>Phasellus quam turpis, feugiat sit amet ornare in, hendrerit in lectus.
													Praesent semper mod quis eget mi. Etiam eu ante risus. Aliquam erat volutpat.
													Aliquam luctus et mattis lectus sit amet pulvinar. Nam turpis nisi
													consequat etiam.</p>
													<footer>
														<a href="#" class="button icon solid fa-info-circle">Find out more</a>
													</footer>
												</section>
<?php include(__DIR__.'/footer.php')?>
