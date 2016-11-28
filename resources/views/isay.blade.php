<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>나는</title>
<!-- <link rel="icon" href="/images/common/favicon.ico" type="image/x-icon"/> -->
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/iam.css">
</head>
<body>
    <div id="container">
        <span id="total"><b>0</b></span>

        <div class="wrap_candle">
            <img src="images/candle_bg.jpg" class="img-responsive center-block" alt="Responsive image">
        </div>

        <img src="images/btn_candle.png" id="enter">
        
        <!-- <div class="wrap_button text-right">
            <button type="button" class="btn btn-lg btn-danger" onclick="enter();">참여하기</button>
        </div> -->

        <!-- Modal -->
        <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">나는</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="gender">성별</label><br />
                            <label class="radio-inline"><input type="radio" name="gender" value="m">남자</label>
                            <label class="radio-inline"><input type="radio" name="gender" value="f">여자</label>
                            <!--<select class="form-control" id="gender">
                                <option value="m">남</option>
                                <option value="f">여</option>
                            </select>-->
                        </div>
                        <div class="form-group">
                            <label for="age">나이</label>
                            <input type="number" class="form-control" id="age">
                        </div>
                        <div class="form-group">
                            <label for="comment">하고싶은말</label>
                            <input type="text" class="form-control" id="comment">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                        <button type="button" class="btn btn-primary" onclick="iam(this);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 확인">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://jsgetip.appspot.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/iam.js"></script>
</body>
</html>

