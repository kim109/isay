function isSafari() {
  var ua = window.navigator.userAgent;
  //return /(iPad|iPhone|iPod).*WebKit/.test(ua) && !/(CriOS|OPiOS)/.test(ua);
  return /^((?!chrome|android|crios|fxios).)*safari/i.test(window.navigator.userAgent);;
}

function getCookie(name) {
    var nameEQ = name + "=";
    
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(nameEQ) != -1) return c.substring(nameEQ.length,c.length);
    }
    return null;
} 

var createGUID = function() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
        return v.toString(16);
    });
}

function prependZero(num, len) {
    while(num.toString().length < len) {
        num = '0' + num;
    }
    return num;
}

function iam(e) {
    var gender = $(':radio[name="gender"]:checked').val();
    var age = $('#age').val();
    var comment = $('#comment').val();

    if (gender == undefined) {
        alert('성별을 선택해주세요.');
        return;
    }
    if ($.trim(age) == '') {
        alert('나이를 입력해주세요.');
        return;
    }

    $(e).button('loading');
    $.ajax({
        type: 'post',
        url: 'do.php',
        data: {
            guid: guid,
            gender: gender,
            age: age,
            comment: comment
        },
        success: function(resp) {
            $(e).button('reset');
            if (resp.Result == 'Fail') {
                alert(resp.Message);
                return;
            }
            $('#inputModal').modal('hide');
            location.href = '/report/korea';
        },
        error: function () {
            alert('서버와의 통신이 원활하지 않습니다.');
            $(e).button('reset');
        },
        complete: function() {
        }
    });
}

function enter () {
    if (!ios) {
        alert('iOS 사용자만 참가할 수 있습니다.');
        return;
    }

    if (isMember) {
        alert('이미 참가하셨습니다.');
        return;
    }

    $('#inputModal').modal();
}

var guid = null, fire = 0, total = 0, isMember = false;
var ios = true;
$(function() {
    if (!/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        alert('iOS 사용자만 참가할 수 있습니다.');
        ios = false;
    } else {
        if (!isSafari()) {
            alert('Safari 브라우저에서만 참가 할 수 있습니다.');
            ios = false;
        }
    }
/*
    setInterval(function(){
        var no = prependZero(fire, 5);
        var src = 'images/fire(412X765)/fire_'+no+'.png';

        $('#fire').attr('src', src);

        if (fire >= 77)
            fire = 0;
        fire++;
    }, 100);
*/
    guid = getCookie('guid');
    if (guid === null) {
        guid = createGUID();

        document.cookie = 'guid='+guid;
    }

    $.ajax({
        type: 'post',
        url: '/total',
        data: JSON.stringify({id: guid}),
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Content-type','application/json');
        },
        success: function(resp) {
            if (resp.result === 'success') {
                if (resp.isMember) {
                    if (ios)
                        alert('이미 참가하셨습니다.');
                    isMember = true;
                }
                total = resp.total;
                $('#total').find('b').text(total);
            }
        },
        error: function () {
            
        }
    });

    $('#enter').click(enter);
});
