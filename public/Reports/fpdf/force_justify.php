<?php
//var_dump($arrayAcademico['hora']);
require('fpdf.php');

class PDF extends FPDF {
    
        public function Header() {
             
            $this->Image('img/logoundac.png',20,8,18);
            $this->Image('img/logo18.png',172,8,25);

            $this->SetFont('Helvetica', 'B', 14);
            $this->SetXY(30, 12);
            $this->Cell(150, 6, utf8_decode('UNIVERSIDAD NACIONAL DANIEL ALCIDES CARRIÓN'),0,1,'C');

            $this->SetFont('Arial', 'B', 12);
            $this->SetX(30);
            $this->Cell(150, 6, utf8_decode('DIRECCIÓN GENERAL DE INFORMÁTICA Y ESTADÍSTICA'),0,1,'C');

            $this->SetFont('Arial', 'B', 12);
            $this->SetX(30);
            $this->Cell(150, 6, utf8_decode('OFICINA DE ESTADÍSTICA'),0,1,'C');

            $this->Line(30, 30, 210-30, 30);	
            $this->Line(30, 31, 210-30, 31);
        }
      
        public function Footer() {
            $parametros=null;
            if (isset($_GET['parametros'])) {
                $parametros = unserialize($_GET['parametros']);    
            }
            $hora=$parametros['academico']['hora'];
            $this->SetFont('Times', 'B',7);
            
            $this->Line(30, 270, 210-30, 270);	
            $this->Line(30, 271, 210-30, 271);
            $this->SetXY(30, -27);
            $this->Cell(75, 8, utf8_decode("Hora : ".$hora),0,0,'L');
            $this->Cell(75, 8, utf8_decode('Sistema de Gestión | Informática - UNDAC'),0,0,'R');
            
        }
function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
	$k=$this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
	{
		$x=$this->x;
		$ws=$this->ws;
		if($ws>0)
		{
			$this->ws=0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation);
		$this->x=$x;
		if($ws>0)
		{
			$this->ws=$ws;
			$this->_out(sprintf('%.3F Tw',$ws*$k));
		}
	}
	if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
	$s='';
	if($fill || $border==1)
	{
		if($fill)
			$op=($border==1) ? 'B' : 'f';
		else
			$op='S';
		$s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x=$this->x;
		$y=$this->y;
		if(is_int(strpos($border,'L')))
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(is_int(strpos($border,'T')))
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(is_int(strpos($border,'R')))
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(is_int(strpos($border,'B')))
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!='')
	{
		if($align=='R')
			$dx=$w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx=($w-$this->GetStringWidth($txt))/2;
		elseif($align=='FJ')
		{
			//Set word spacing
			$wmax=($w-2*$this->cMargin);
			$this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt,' ');
			$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
			$dx=$this->cMargin;
		}
		else
			$dx=$this->cMargin;
		$txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		if($this->ColorFlag)
			$s.='q '.$this->TextColor.' ';
		$s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
		if($this->underline)
			$s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s.=' Q';
		if($link)
		{
			if($align=='FJ')
				$wlink=$wmax;
			else
				$wlink=$this->GetStringWidth($txt);
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$wlink,$this->FontSize,$link);
		}
	}
	if($s)
		$this->_out($s);
	if($align=='FJ')
	{
		//Remove word spacing
		$this->_out('0 Tw');
		$this->ws=0;
	}
	$this->lasth=$h;
	if($ln>0)
	{
		$this->y+=$h;
		if($ln==1)
			$this->x=$this->lMargin;
	}
	else
		$this->x+=$w;
}

    var $extgstates = array();

	function SetAlpha($alpha, $bm='Normal')
	{
		$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
		$this->SetExtGState($gs);
	}

	function AddExtGState($parms)
	{
		$n = count($this->extgstates)+1;
		$this->extgstates[$n]['parms'] = $parms;
		return $n;
	}

	function SetExtGState($gs)
	{
		$this->_out(sprintf('/GS%d gs', $gs));
	}

	function _enddoc()
	{
		if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
			$this->PDFVersion='1.4';
		parent::_enddoc();
	}

	function _putextgstates()
	{
		for ($i = 1; $i <= count($this->extgstates); $i++)
		{
			$this->_newobj();
			$this->extgstates[$i]['n'] = $this->n;
			$this->_out('<</Type /ExtGState');
			$parms = $this->extgstates[$i]['parms'];
			$this->_out(sprintf('/ca %.3F', $parms['ca']));
			$this->_out(sprintf('/CA %.3F', $parms['CA']));
			$this->_out('/BM '.$parms['BM']);
			$this->_out('>>');
			$this->_out('endobj');
		}
	}

	function _putresourcedict()
	{
		parent::_putresourcedict();
		$this->_out('/ExtGState <<');
		foreach($this->extgstates as $k=>$extgstate)
			$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
		$this->_out('>>');
	}

	function _putresources()
	{
		$this->_putextgstates();
		parent::_putresources();
	}
}
?>
