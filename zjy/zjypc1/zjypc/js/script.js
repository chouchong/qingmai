    // pc_景点高度改变
    function scenic_heightchange() {
        $(".sf_sel").css("min-height", "100px");
        $(".s_selectdate").css("min-height", "100px");
        var lh = $(".s_selectdate").height();
        var rh = $(".sf_sel").height();
        if (lh > rh) {
            $(".sf_sel").css("min-height", lh);
        } else {
            $(".s_selectdate").css("min-height", rh);
        }
    }
    // pc_diver高度改变
    function diver_heightchange() {
        $(".diverform").css("min-height", "100px");
        $(".selectdate").css("min-height", "100px");
        var lh = $(".selectdate").height();
        var rh = $(".diverform").height();
        if (lh > rh) {
            $(".diverform").css("min-height", lh);
        } else {
            $(".selectdate").css("min-height", rh);
        }
    }
    // pc_diverorder高度改变
    function diverorder_heightchange() {
        $(".od_forml").eq(0).css("min-height", "100px");
        $(".od_forml").eq(1).css("min-height", "100px");
        var lh = $(".od_forml").eq(0).outerHeight();
        var rh = $(".od_forml").eq(1).outerHeight();
        if (lh > rh) {
            $(".od_forml").eq(1).css("height", lh);
        } else {
            $(".od_forml").eq(0).css("min-height", rh);
        }
    }
    // pc_visa高度改变
    function visa_heightchange() {
        $(".v_left").eq(0).css("min-height", "100px");
        $(".v_left").eq(1).css("min-height", "100px");
        var lh = $(".v_left").eq(0).height();
        var rh = $(".v_left").eq(1).height();
        if (lh > rh) {
            $(".v_left").eq(1).css("min-height", lh);
        } else {
            $(".v_left").eq(0).css("min-height", rh);
        }
    }
