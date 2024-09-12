@extends('layouts.pdf')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">

                
 <style>
  @import url('https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap');
  
   body{
     font-family: 'Oleo Script', cursive;

   }

   .p_main {
            text-align: center;
            font-size: 10px;
           padding-top: 60px;
          
           
        }
    /*new*/


/*.navigation-links-nav {*/
/*  flex: 0 0 auto;*/
/*  display: flex;*/
/*  align-items: center;*/
/*  flex-direction: row;*/
/*  justify-content: flex-start;*/
/*}*/
.navigation-links-root-class-name10 {
  top: 9px;
  /*right: 17px;*/
  position: absolute;
  margin-top: -30px;
  margin-left: 405px;
  /*margin-right: 12px;*/
}
.navigation-links-root-class-name9{
  top: 6px;
  /*right: 17px;*/
  position: absolute;
  margin-top: -25px;
  margin-left: 560px;
  /*margin-right: 12px;*/
}
.navigation-links-root-class-name11 {
  bottom: 9px;
  /*right: 17px;*/
  position: absolute;
  margin-top: -16px;
  margin-left: 390px;
  /*margin-right: 12px;*/
}

.home-container {
  width: 100%;
  display: flex;
  overflow: auto;
  min-height: 100vh;
  align-items: center;
  flex-direction: column;
  justify-content: flex-start;
  margin-left:30px;
  
}
.home-header {
  width: 100%;
  height: 93px;
  display: flex;
  position: relative;
  max-width: var(--dl-size-size-maxwidth);
  align-items: center;
  padding-top: var(--dl-space-space-twounits);
  padding-left: var(--dl-space-space-threeunits);
  padding-right: var(--dl-space-space-threeunits);
  padding-bottom: var(--dl-space-space-twounits);
  justify-content: space-between;
}
/*.home-text {*/
  /*top: 47px;*/
  /*left: 0px;*/
  /*position: absolute;*/
  /*font-size: 22px;*/
/*}*/

/*.home-text1 {*/
/*  top: 15px;*/
/*  left: 100px;*/
/*  position: absolute;*/
/*  font-size: 28px;*/
/*  align-self: stretch;*/
/*}*/


/*.home-container {*/
/*  width: 100%;*/
/*  display: flex;*/
/*  overflow: auto;*/
/*  min-height: 100vh;*/
/*  align-items: center;*/
/*  flex-direction: column;*/
/*  justify-content: flex-start;*/
/*}*/
.home-blog {
  /*width: 100%;*/
  height: 445px;*/
  display: flex;
  padding: 7px;
  position: relative;
  max-width: var(--dl-size-size-maxwidth);
  align-items: center;
  /*padding-top: 5px;*/
  border: 2px solid black;
  flex-direction: column;
  justify-content: space-between;
}
.home-container1 {
  /*border: 2px dashed rgba(120, 120, 120, 0.4);*/
  display: flex;
  position: relative;
  align-items: center;
  margin-bottom: var(--dl-space-space-twounits);
  flex-direction: column;
  justify-content: space-between;
}
.home-text {
  top: 18px;
  left: -66px;
  width: 457px;
  height: 41px;
  position: absolute;
  font-size: 12px;
}
.home-ul {
  top: 50px;
  left: 0px;
  width: 236px;
  height: 100px;
  position: absolute;
}
.home-container2 {
    height: 160px;
  /*border: 2px dashed rgba(120, 120, 120, 0.4);*/
  display: flex;
  align-items: center;
  margin-bottom: var(--dl-space-space-twounits);
  flex-direction: column;
  justify-content: space-between;
}
.home-feature-card {
  width: 100%;
  height: 0px;
  display: flex;
  /*padding: var(--dl-space-space-unit);*/
  position: relative;
  /*max-width: var(--dl-size-size-maxwidth);*/
  /*border-radius: 2px solid black;*/
  /*box-shadow: 5px 5px 10px 0px rgba(18, 18, 18, 0.1);*/
  /*transition: 0.3s;*/
  /*align-items: flex-start;*/
  /*flex-direction: column;*/
  /*justify-content: flex-start;*/
}

.home-text04 {
  left: 50px;
  bottom: 0px;
  position: absolute;
  font-size: 12px;
  align-self: flex-start;
  font-style:normal;
  font-family:Inter ;
      margin-left: 25px;
}
.home-blog{
    width:90%;
    margin-left: 25px;
}
.table {
    width:96%;
    margin-left: 25px;
}
.nav-item3{
  border: 1px solid black;
  background-color: rgb(206, 199, 199);
}
td{
  border: 1px solid black;

}



    </style>

    <body>
        <htmlpageheader><br><br><br>
            <p class="p_main">QEVERIA E KOSOVËS-MINISTRIA E SHËNDETËSISË / VLADA KOSOVA - MINISTARSTVO ZDRAVSTVA </p>
            <div class="home-container">
                <header data-role="Header" class="home-header">
                  <label class="home-text">CERTIKATË SHËNDETËSORE <br><i>ZDRAVSTVENO UVERENJE</i>  </label>
                  <!--<label class="home-text1">ZDRAVSTVENO UVERENJE</label>-->
                  <nav class="navigation-links-nav navigation-links-root-class-name10">
                    <span class="navigation-links-text">
                        <span style="font-size: 22px; color:red;"> {{ $group['reg_no'] }}
                    </span> </nav>
                                      <nav class="navigation-links-nav navigation-links-root-class-name9">

                        
                                       
                <table class="nav-item3" style="width:10%">
    
                    <tr style="text-align:center">
                      <td><b>&nbsp;C&nbsp;</b></td>
                      <td><b>&nbsp;M&nbsp;</b></td>
                      <td><b>&nbsp;0&nbsp;</b></td>
                      <td><b>&nbsp;2&nbsp;</b></td>
                      <td><b>&nbsp;0&nbsp;</b></td>
                      <td><b>&nbsp;1&nbsp;</b></td>
                    </tr>
                  
                  </table>
                       
                        </nav>
                        
                  
                  
                </header>
              </div>
            <h5 class="text-center" style="font-size:12px; margin-left: 25px;margin-top:-30px; margin-bottom:-12px; ">Për punësim <br> <i> Za zaposljenje</i><br>&emsp; </h5>

            @if (isset($group['patient']))
                <table class="table table-bordered pdf-header" style="margin-top:-450px;">
                    <tbody>
                        <tr>
                            <td width="50%" style="border: 2px solid blackc; padding:4px;">
                                <span class="s_title" style="font-size:9px;">
                                   {{ __('Institucioni Shëndetësor /') }} </span>
                                   <span class="s_title" style="font-size:9px; "><i>
                                   {{ __(' Zdravstvena Institucija') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                    &nbsp; {{ $group['branch']['name'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('NIP / ') }} 
                                <span class="title" style="font-size:9px;"><i>{{ __(' BIP') }} </i></span>
                                
                            
                                <span class="data" style="font-size:10px;">
                                    <!--?-->
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black;padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Kodi / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Kod') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                    &nbsp; {{ $group['branch']['fiskal_no'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black;padding:4px">
                                <span class="title" style="font-size:9px;">{{ __('Nr. Personal / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Licni Br.') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                     &nbsp; {{ $group['patient']['national_id'] }}
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px">
                                @if ($group['visit_type'] == 'Publik')
                                    <span class="title" style="font-size:9px;">{{ __('Publik / ') }} </span>
                                    <span class="title" style="font-size:9px;"><i>{{ __(' Javna') }} </i></span>
                                    
                                    <span class="data" style="font-size:10px;">
                                         &nbsp; {{ $group['visit_type'] }}
                                    </span>
                                @else($group['visit_type'] == 'Privat')
                                    <span class="title" style="font-size:9px;">{{ __('Privat / ') }} </span>
                                    <span class="title" style="font-size:9px;"><i>{{ __(' Privatna') }} </i></span>
                                  
                                    <span class="data" style="font-size:10px;">
                                         &nbsp; {{ $group['visit_type'] }}
                                    </span>
                                @endif
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Emri / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Ime') }} </i></span>
                                 <span class="title" style="font-size:9px;">&nbsp;{{ __('Mbiemri / ') }}</span>
                                  <span class="title" style="font-size:9px;"><i>{{ __(' Prezime') }} </i></span>
                                    
                                <span class="data" style="font-size:10px;">
                                     &nbsp; {{ $group['patient']['name'] }}
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Vendi / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Mesto') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                     &nbsp; {{ $group['branch']['address'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Emri i prindit / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Ime roditelja') }} </i></span>
         
                                <span class="data" style="font-size:10px;">
                                     &nbsp; {{ $group['patient']['passport_no'] }}
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Nr.kartelës Shëndetësore / ') }} </span>
                                    <span class="title" style="font-size:9px;"><i>{{ __(' Br. Zdravstvenog Kartona') }} </i></span>
                                <span class="data" style="font-size:10px;">
                                    <!--new-->
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Viti i  lindjes / ') }} </span>
                                 <span class="title" style="font-size:9px;"><i>{{ __(' Godina rodjenja') }} </i></span>
                                <span class="data">
                                  
                                    <span class="data"style="font-size:10px;">
                                         &nbsp; {{ $group['patient']['dob'] }}
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Nr. i Regjistrit / ') }} </span>
                                 <span class="title" style="font-size:9px;"><i>{{ __(' Br. Registra') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                     &nbsp;{{ $group['protocol_no'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Gjinia / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Pol') }} </i></span>
                                <span class="data">
                                  
                                    <span class="data" style="font-size:10px;">
                                         &nbsp;{{ $group['patient']['gender'] }}
                                    </span>
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Mjeku / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Lekar') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                   &nbsp;{{ $group['doctor']['name'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Adresa / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Adresa') }} </i></span>
                             
                                <span class="data" style="font-size:10px;">
                                     &nbsp;{{ $group['patient']['address'] }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Kodi i mjekut / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Sifra Lekara') }} </i></span>
                                
                                <span class="data" style="font-size:10px;">
                                    &nbsp;{{ $group['doctor']['doctor_code'] }}
                                </span>
                            </td>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Alergjitë / ') }} </span>
                                <span class="title" style="font-size:9px;"><i>{{ __(' Alergije') }} </i></span>
                                
                                @if ($group['alergy'] == 'Mohon')
                                    <span class="data" style="font-size:10px;">
                                         &nbsp;{{ $group['alergy'] }}
                                    </span>
                                @else($group['alergy'] == 'Pohon')
                                    <span class="data" style="font-size:10px;">
                                         &nbsp;{{ $group['alergy'] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('Tel / ') }} </span>
                                 <span class="title" style="font-size:9px;"><i>{{ __(' Tel') }} </i></span>
                                
                                
                                <span class="data" style="font-size:10px;">
                                    &nbsp; {{ $group['branch']['phone'] }}
                                </span>
                            </td>
                             <td width="50%" style="border: 2px solid black; padding:4px;">
                                <span class="title" style="font-size:9px;">{{ __('E-mail') }} </span>
                                
                                <span class="data" style="font-size:10px;">
                                   &nbsp;{{ $group['branch']['email'] }}
                                </span>
                            </td>
                        </tr>
                       
                     </tr>
                    </tbody>
                </table>
               
            <!--<div class="div1"><b>Konstatohet se / <i>Konstatira se:</i></b>-->
            <!--    <br>-->
            <!--     <textarea>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</textarea>-->
            <!-- <br>-->
            <!-- &nbsp; ___________________________________________________________________-->
            <!--  <p style="margin-bottom:3px; margin-top:3px;">&nbsp;&nbsp;Mjeku i pergjithshem, Specialisti i Mjekesise Familjare ose Pediatri</p>-->
            <!--</div>-->
        
    </div>
    <br />
     
        <div class="home-blog">
          <div class="home-container1"></div>
          <h1 class="home-text" style="font-size:10px;">Konstatohet se / <i>Konstatira se:</i> </h1>
          <ul class="home-ul list" style="list-style-type:none">
            <li class="list-item"><span>TA:</span>&nbsp;{!! str_replace("\n", '<br />', $group['ta']) !!}</li>
            <li class="list-item"><span>SPO2:</span>&nbsp;{!! str_replace("\n", '<br />', $group['spo2']) !!}</li>
            <li class="list-item"><span>FC:</span>&nbsp;{!! str_replace("\n", '<br />', $group['fc']) !!}</li>
          </ul>
            <span>{!! str_replace("\n", '<br />', $group['comment']) !!}</span>
          <div class="home-container2"></div>
          <div class="home-feature-card">
            <h2 class="home-text04" style="margin-left:-1px">
              <span>
                ______________________________________________________________________
              </span>
              <br />
              <span style="font-size:11px;">
                Mjeku i Përgjithshëm, Specialisti i Mjekësisë Familjare ose
                Pediatri&nbsp;
              </span>
              <br />
              <span style="font-size:11px;">
                <i>Lekar opste prakse, Specijalista Porodicne Medicine ili Pedijatar</i>
              </span>
            </h2>
          </div>
        </div>




           
               <div>
                    <span><h5 > &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;Data: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Vendi
                     &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                     &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; V.V &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Drejtori</span><br>
                        
                       <span class="fix">  &nbsp; &nbsp;&nbsp; &nbsp; {{ $group['visit_date'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                        <i> Mesto:</i>&nbsp; {{ $group['branch']['address'] }} </span><br>
                                          <nav class="navigation-links-nav navigation-links-root-class-name11">
                    <span class="navigation-links-text2" style="margin-bottom:50%; top: 0px">
                        <span><i>M.P.</i></span>
                    </span> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <span class="navigation-links-text1"><span><i>Direktor:</i>&nbsp;_________________________</span></span></span>
                  </nav>
                        
                    <p style="margin-left: 80%;  font-size: 10px; margin-top:-1px; ">Nënshkrimi / Potpis</p></span>
                </div>
                

            @endif
    </body>

    </html>
@endsection
