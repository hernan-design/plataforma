@extends('emails.layout')

@section('content')
	<table>
        <tr>
            <td align="center" valign="top" style="padding-bottom:10px;">
                <span>tienes una solicitud de contacto:</span>
            </td>
        </tr>
		<tr>
        	<td align="center" valign="top">
            	<table border="0" cellspacing="0" cellpadding="0" width="440">
                    <tr>
                    	<td style="background-color:#FFFFFF;padding:10px;border-right:1px solid #e5e5e5;border-bottom:1px solid #e5e5e5;">
                    		<table>
                    			<tr>
                                    <td width="87">
                                    	<div style="text-align:center;">
                                    		<div style="text-align: right;">
                                    			<a href="{{{ $_inst_url.$_url_user_action }}}" style="text-decoration:none;display:inline-block;padding: 0px 15px 0px 0px;" title="{{ $_name_user_action }}" target="_blank">
                                    				<img align="none" border="0" height="72" src="{{ $_image_user_action }}" style="border-radius: 50%; width: 72px; height: 72px; margin: 0px;" width="72">
                                    			</a>
                                    		</div>
                                    	</div>
                                    </td>
                                    <td valign="middle" width="300">
                                    	<div>
                                    		<div>
                                    			<span style="color:{{ $_inst_color }};font-size:18px;">{{ $_name_user_action }}</span><br>
												@if(isset($_profession_user_action) && !empty($_profession_user_action))
													<span>{{ $_profession_user_action }}</span><br>
												@endif
												<span><a href="{{{ $_inst_url.$_url_user_action }}}" style="text-decoration:none;" title="{{ $_name_user_action }}" target="_blank">{{ $_nickname_user_action }}</a>
												</span>
											</div>
										</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
		<tr>
			<td>
				@include('emails.calltoaction', ['label' => 'Aceptar contacto', 'action' => sprintf('%s%s', $_inst_url, $_url_confirm), 'color' => $_inst_color])
            </td>
		</tr>
	</table>
@stop