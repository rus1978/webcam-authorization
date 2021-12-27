<div id="video-form" data-status="auth">
    <canvas id="canvas"></canvas>

    <div class="camera">
        <video id="video">Video stream not available.</video>
    </div>

    <div class="output">
        <img id="photo" alt="The screen capture will appear in this box." src="#">
    </div>

    <p class="lead button-take-photo">
        <a id="button-take-photo"  class="btn btn-lg btn-secondary fw-bold border-info bg-info">{{$buttonTakePhoto}}</a>
    </p>
    <p class="lead button-start-camera">
        <a id="button-start-camera" class="btn btn-lg btn-secondary fw-bold border-white bg-white">{{$buttonStartCamera}}</a>
    </p>
</div>