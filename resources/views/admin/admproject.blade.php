@extends('template.master')
<title>My Task List</title>
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My Task List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container-fluid">
    <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-milestone-tab" data-toggle="pill" href="#custom-tabs-one-milestone" role="tab" aria-controls="custom-tabs-one-milestone" aria-selected="true">Milestone</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-dashboard-tab" data-toggle="pill" href="#custom-tabs-one-dashboard" role="tab" aria-controls="custom-tabs-one-dashboard" aria-selected="false">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-files-tab" data-toggle="pill" href="#custom-tabs-one-files" role="tab" aria-controls="custom-tabs-one-files" aria-selected="false">Files</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-timeline-tab" data-toggle="pill" href="#custom-tabs-one-timeline" role="tab" aria-controls="custom-tabs-one-timeline" aria-selected="false">Timeline</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-detail-tab" data-toggle="pill" href="#custom-tabs-one-detail" role="tab" aria-controls="custom-tabs-one-detail" aria-selected="false">Detail</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-milestone" role="tabpanel" aria-labelledby="custom-tabs-one-milestone-tab">
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-dashboard" role="tabpanel" aria-labelledby="custom-tabs-one-dashboard-tab">
                     Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-files" role="tabpanel" aria-labelledby="custom-tabs-one-files-tab">
                     Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-timeline" role="tabpanel" aria-labelledby="custom-tabs-one-timeline-tab">
                  <div class="row">
<div class="col-md-12">
    <!-- The time line -->
    <div class="timeline">
      <!-- timeline time label -->
      <div class="time-label">
        <span class="bg-red">10 Feb. 2014</span>
      </div>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <div>
        <i class="fas fa-envelope bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fas fa-clock"></i> 12:05</span>
          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

          <div class="timeline-body">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
            weebly ning heekya handango imeem plugg dopplr jibjab, movity
            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
            quora plaxo ideeli hulu weebly balihoo...
          </div>
          <div class="timeline-footer">
            <a class="btn btn-primary btn-sm">Read more</a>
            <a class="btn btn-danger btn-sm">Delete</a>
          </div>
        </div>
      </div>
      <!-- END timeline item -->
      <!-- timeline item -->
      <div>
        <i class="fas fa-user bg-green"></i>
        <div class="timeline-item">
          <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
          <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
        </div>
      </div>
      <!-- END timeline item -->
      <!-- timeline item -->
      <div>
        <i class="fas fa-comments bg-yellow"></i>
        <div class="timeline-item">
          <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
          <div class="timeline-body">
            Take me to your leader!
            Switzerland is small and neutral!
            We are more like Germany, ambitious and misunderstood!
          </div>
          <div class="timeline-footer">
            <a class="btn btn-warning btn-sm">View comment</a>
          </div>
        </div>
      </div>
      <!-- END timeline item -->
      <!-- timeline time label -->
      <div class="time-label">
        <span class="bg-green">3 Jan. 2014</span>
      </div>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <div>
        <i class="fa fa-camera bg-purple"></i>
        <div class="timeline-item">
          <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
          <div class="timeline-body">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
          </div>
        </div>
      </div>
      <!-- END timeline item -->
      <!-- timeline item -->
      <div>
        <i class="fas fa-video bg-maroon"></i>

        <div class="timeline-item">
          <span class="time"><i class="fas fa-clock"></i> 5 days ago</span>

          <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

          <div class="timeline-body">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen></iframe>
            </div>
          </div>
          <div class="timeline-footer">
            <a href="#" class="btn btn-sm bg-maroon">See comments</a>
          </div>
        </div>
      </div>
      <!-- END timeline item -->
      <div>
        <i class="fas fa-clock bg-gray"></i>
      </div>
    </div>
  </div>
  <!-- /.col -->
</div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>

    </div>
@endsection