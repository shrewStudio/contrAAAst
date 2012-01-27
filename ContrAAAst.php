<?php
/**
 * Comparison between two colors to test their difference of contrast
 * 
 * Use the algorithm supplied by the WCAG 2.0 and respects the directive 1.4.6
 * This algorythm is "work in progress" status
 *
 * @see http://www.w3.org/TR/WCAG/
 * @see http://www.w3.org/TR/UNDERSTANDING-WCAG20/visual-audio-contrast-contrast.html
 * 
 * @author shrewStudio <atelier.muasaraigne@gmail.com>
 * @version 12.01 (wip)
 */
class ContrAAAst
{
    
    /**
     * Color contrast comparison between 2 RGB colors
     * 
     * @param array $color1 array(RRR,GGG,BBB) when R*,G* & B* are float|int
     * @param array $color2 array(RRR,GGG,BBB) when R*,G* & B* are float|int
     * @return boolean true if contrast color is correct, false else. 
     */
    public function contrast_color(Array $color1, Array $color2)
    {
        $r = max($color1[0],$color2[0]) - min($color1[0],$color2[0]);
        $r += max($color1[1],$color2[1]) - min($color1[1],$color2[1]);
        $r += max($color1[2],$color2[2]) - min($color1[2],$color2[2]);
        
        return ($r >= 500) ? true : false;
    }
    
    
    /**
     * Luminance Comparison between 2 RGB colors
     * 
     * @see http://www.w3.org/TR/WCAG20/#contrast-ratiodef
     * @param array $color1 array(RRR,GGG,BBB) when R*,G* & B* are float|int
     * @param array $color2 array(RRR,GGG,BBB) when R*,G* & B* are float|int
     * @return float ratio value
     */
    public function contrast_brightness(Array $color1, Array $color2)
    {
        $r1 = $this->relative_brightness($color1[0], $color1[1], $color1[2]);
        $r2 = $this->relative_brightness($color2[0], $color2[1], $color2[2]);
        
        return (max($r1,$r2) + 0.05) / (min($r1,$r2) + 0.05);
    }
    
    
    /**
     * Relative brightness of any point in a colorspace
     * 
     * @see http://www.w3.org/TR/WCAG20/#relativeluminancedef
     * @param type $r red rgb value
     * @param type $g green rgb value
     * @param type $b blue rgb value
     * @return float relative luminance
     */
    protected function relative_brightness($r,$g,$b)
    {
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;
        
        $r = ($r <= 0.03928) ? $r / 12.92 : $r = pow(($r + 0.055) / 1.055, 2.4);
        $g = ($g <= 0.03928) ? $g / 12.92 : $g = pow(($g + 0.055) / 1.055, 2.4);
        $b = ($b <= 0.03928) ? $b / 12.92 : $b = pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2216 * $r + 0.7152 * $g + 0.0722 * $b;
    }


}


?>
