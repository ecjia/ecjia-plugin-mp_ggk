<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title}</title>
    <link rel="stylesheet" type="text/css" href="{$activity_style_css}">
    <link rel="stylesheet" type="text/css" href="{$bootstrap_min_css}">
    <link rel="stylesheet" type="text/css" href="{$models_css}">
</head>

<body class="activity-scratch-card-winning">
    <div class="main">
        <div class="cover">
        	<div class="cover-content">
	            <img src="{$bannerbg_png}">
	            <div id="prize"></div>
	            <div id="scratchpad"></div>
            </div>
        </div>
        <div class="content">
            <div class="boxcontent boxwhite">
                <div class="box">
                    <div class="title-brown">{t domain="mp_ggk"}奖项设置{/t}</div>
                    {if $prize}
                    <div class="Detail">
                        <!-- {foreach from=$prize item=val }-->
                            <p>
                                {if $val.prize_level eq '0'} {t domain="mp_ggk"}特等奖：{/t} {elseif $val.prize_level eq '1'} {t domain="mp_ggk"}一等奖：{/t} {elseif $val.prize_level eq '2'} {t domain="mp_ggk"}二等奖：{/t} {elseif $val.prize_level
                                eq '3'} {t domain="mp_ggk"}三等奖：{/t} {elseif $val.prize_level eq '4'} {t domain="mp_ggk"}四等奖：{/t} {elseif $val.prize_level eq '5'} {t domain="mp_ggk"}五等奖：{/t} {/if} {$val.prize_name}{if $val.prize_type eq 2}（{$val.prize_value}）{/if}{t domain="mp_ggk" 1={$val.prize_number}}（剩余奖品数量：%1）{/t}
                            </p>
	                        <!-- {/foreach} -->
                    </div>
                    {else}
                    <p class="Detail">{t domain="mp_ggk"}暂无设置{/t}</p>
                    {/if}
                </div>
            </div>
            <div class="boxcontent boxwhite">
                <div class="box">
                    <div class="title-brown">{t domain="mp_ggk"}活动说明{/t}</div>
                    <div class="Detail">
                        <p>{t domain="mp_ggk"}剩余抽奖次数：{/t}
                            <span id="num"> {$prize_num} </span>
                        </p>
                        <p>{$description}</p>
                    </div>
                </div>
            </div>
            <div class="boxcontent boxwhite">
                <div class="box">
                    <div class="title-brown">{t domain="mp_ggk"}中奖记录{/t}</div>
                    <div class="Detail">
                        {if $list}
                        <div class="content">
                            <!-- {foreach from=$list item=val}-->
                            <p> {$val.user_name} {t domain="mp_ggk"}获得奖品 ：{/t}{$val.prize_name} {if $val.prize_type eq 2}（{$val.prize_value}）{/if}</p>
                            <!-- {/foreach} -->
                        </div>
                        {else}
                        <p>{t domain="mp_ggk"}暂无获奖记录{/t}</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>

        <!-- 我的奖品 -->
        <div class="prize-btn">
            <a class="external" href="{$prize_url}">
                <img width="50%" src="{$my_prize_png}">
            </a>
        </div>
    </div>
    <script type="text/javascript" src="{$jquery_min_js}"></script>
    <script type="text/javascript" src="{$wScratchPad_js}"></script>
    <script type="text/javascript" src="{$framework7_min_js}"></script>
    
    <script type="text/javascript">
        $(function () {
        	var js_lang = {$js_lang};
        	
            $.get('{$form_action}', {
                	act: 'draw'
                }, function (result) {
                if (result.state == 'error') {
                    $("#scratchpad").wScratchPad('enabled');
                    alert(result.message);
                    return false;
                }
                if (result.state == 'success') {
                    $("#prize").html(result.prize_name);
                }
                $("#scratchpad").wScratchPad({
                    width: 220,
                    height: 60,
                    color: "#a9a9a7", //覆盖的刮刮层的颜色
                    scratchDown: function (e, percent) {
                        $(this.canvas).css('margin-right', $(this.canvas).css(
                            'margin-right') == "0px" ? "1px" : "0px");
                        if (percent > 23) {
                            $("#scratchpad").wScratchPad('clear');
                            $.get('{$form_action}', {
                                act: 'do',
                            }, function (data) {
                                if (data.state == 'success') {
                                    var msg = js_lang.congratulations + data.prize_name + "\r\n" +
                                        js_lang.get_award;
									confirm(msg, function() {
										location.href = data.link;
                                        return false;
									}, function() {
										location.reload();
                                        return false;
									})
                                } else if (data.state == 'error') {
                                    alert(data.message, function() {
                                    	location.reload();
                                        return false;
									})
                                }
                            });
                        }
                    }
                });
            });
            function alert(text, callback) {
                var app = new Framework7({
                    modalButtonOk: js_lang.ok,
                    modalTitle: js_lang.tip
                });
                app.alert(text, '', callback);
            }

            function confirm(text, callbackOk, callbackCancel) {
                var app = new Framework7({
                    modalButtonOk: js_lang.go_to_award,
                    modalTitle: js_lang.winning,
                    modalButtonCancel: js_lang.recollect_later
                });
                app.confirm(text, '', callbackOk, callbackCancel);
            }
        });
    </script>
</body>

</html>
<!-- {/nocache} -->