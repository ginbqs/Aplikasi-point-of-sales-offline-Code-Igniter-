<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
          <?php $uri = service('uri'); 
          ?>
        <h1 class="m-0"><?php echo count($uri->getSegments())-1 > 0  ? ucwords($uri->getSegments()[count($uri->getSegments())-1]) :'Dashboard';?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <?php foreach ( $uri->getSegments() as $segment): ?>
          <?php 
            $url = substr($uri->getPath(), 0, strpos($uri->getPath(), $segment)) . $segment;
            $is_active =  $url == $uri->getPath();
          ?>


          <li class="breadcrumb-item <?php echo $is_active ? 'active': '' ?>">
            <?php if($is_active): ?>
              <?php echo ucfirst($segment) ?>
            <?php else: ?>
              <a href="<?php echo site_url($url) ?>"><?php echo ucfirst($segment) ?></a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
          <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v1</li> -->
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>