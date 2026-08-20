#!/usr/bin/perl

use MIME::Lite;
use Net::SMTP;

$LOGPATH = "";

$DT=`date +'%Y-%m-%d %H:%M:%S'`;
chomp($DT);



$HOUR = `date +'%H'`;
chomp($HOUR);

$MIN = `date +'%M'`;
chomp($MIN);

$ADATE = `date +'%Y-%m-%d'`;
chomp($ADATE);

@ARRAY = ("APPUSH.INFOSERVICE.NEWS.PUSH","BN.INFOSERVICE.BUNDLE.NEWS.PUSH","BN.INFOSERVICE.NEWS.PUSH","JOKE.INFOSERVICE.BUNDLE.PUSH","QUOTE.INFOSERVICE.BUNDLE.PUSH","RDNPUSH.INFOSERVICE.NEWS.PUSH","RELIGION.NAMAZ","RNHPUSH.INFOSERVICE.BUNDLE.NEWS.PUSH","RNSPUSH.INFOSERVICE.BUNDLE.NEWS.PUSH","RNSPUSH.INFOSERVICE.NEWS.PUSH","ROMAN.RAMZFACT","ROMAN.RAQUARIUS","ROMAN.RARIES","ROMAN.RAYAT","ROMAN.RCANCER","ROMAN.RCAPRICORN","ROMAN.RCRIFACT","ROMAN.RGEMINI","ROMAN.RHADITH","ROMAN.RJOKE","ROMAN.RLEO","ROMAN.RLIBRA","ROMAN.RPISCES","ROMAN.RQUOTE","ROMAN.RSAGITTARIUS","ROMAN.RSCORPIO","ROMAN.RTAURUS","ROMAN.RTIPSREC","ROMAN.RVIRGO","WEATHER.ABBOTTABAD","WEATHER.FAISALABAD","WEATHER.GUJRANWALA","WEATHER.GUJRAT","WEATHER.HYDERABAD","WEATHER.ISLAMABAD","WEATHER.JHANG","WEATHER.KARACHI","WEATHER.KOHAT","WEATHER.LAHORE","WEATHER.LARKANA","WEATHER.MIANWALI","WEATHER.MULTAN","WEATHER.NAWABSHAH","WEATHER.OKARA","WEATHER.PARACHINAR","WEATHER.PESHAWAR","WEATHER.QUETTA","WEATHER.RAWALPINDI","WEATHER.SAHIWAL","WEATHER.SARGODHA","WEATHER.SHEIKHUPURA","WEATHER.SIALKOT","WEATHER.SUKKUR","JAZZ.FOOTBALL.PUSH.ALERTS");



foreach $SERVICES (@ARRAY)
{
	print "$SERVICES\n";

	$TCOUNTS = "20";
        chomp($TCOUNTS);

	$PCOUNTS = "100";
	chomp($PCOUNTS);

	print "$ADATE|$SERVICES|$TCOUNTS|$PCOUNTS \n";

	`echo "$ADATE|$SERVICES|$TCOUNTS|$PCOUNTS" >> /tmp/test.log`;
}
    
     $code = "100";
     $tcode_count ="200";
        $data .= " <tr>
            <td td bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'> <font size='2' face='Verdana'>$code&nbsp;</td>
            <td td bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'> <font size='2' face='Verdana'>$tcode_count</td>
	    <td td bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'> <font size='2' face='Verdana'>$pcode_count</td>
          </tr>
        ";


if($data ne "")
{
        $from_address = "services.life\@igi.com.pk";
        $address_names = "haroon.ssuet\@gmail.com.com,haroon.saeed\@m3tech.com.pk";

        $heading = "MOBILINK PUSH CONTENT COUNTS ($ADATE)";
        $data = &Get_Out_Data($data);
        &SentEmailFunction($address_names,$from_address,$heading,$data,"");
}



sub SentEmailFunction
{
         $mail_host = "email.igi.com.pk", Hello=>"email.igi.com.pk";
        ($address_names,$from_address,$heading,$message,$attach)= @_;

                $msg = MIME::Lite->new (
                From => $from_address,
                To => $address_names,
                Subject => $heading,
                Type =>'multipart/mixed'
                ) or die "Error creating multipart container: $!\n";

                $msg->attach (
                        Type => 'text/html',
                        Data => $message
                ) or die "Error adding the text message part: $!\n";

                if ($attach ne ''){
                        $msg->attach (
                          Type => 'application/vnd.ms-excel',
                          Path => $attach,
                          Disposition => 'attachment'
                          ) or die "Error adding $file_wav: $!\n";
                } # IF NO RECODE DONT SEND EMAIL.

                MIME::Lite->send('smtp', $mail_host, Timeout=>220);
                $msg->send;
                $date = `date +'%Y-%m-%d %H:%M:%S'`;
                chomp($date);
                print "Mail Send\n";
}

sub Get_Out_Data
{
($DATA) = @_;
my $BG1 = "#D0DAFD";
my $BG2 = "#E8EDFF";
my $W1 = "20%";
my $W2 = "80%";
my $H = "25px";
my $DATE = `date +'%Y-%m-%d'`;
chomp($DATE);

my $OUTDATA = "
<HTML>

<H2  style='font-family:arial;' aling='center'>
        MOBILINK PUSH CONTENT COUNT ($ADATE)
</H2></br>

<TABLE style='padding-left:12px;width:100%;border:1px'>
         <tr>
            <th bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'>Service</th>
            <th bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'>Today Counts</th>
	    <th bgcolor='$BG1' align='left' style='color:black;width:$W1;height:$H'>Yesterday Counts</th>
          </tr>


$DATA

</TABLE>

</HTML>
";

return $OUTDATA;
}

