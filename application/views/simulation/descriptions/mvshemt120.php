<h2>Silicon MIT virtual source HEMT model</sup></h2>
<p>Authors:Ognian Shaloo Rakheja,Dimitri Antoniadis
<br>Organization: Massachusetts Institute of Technology (MIT)
<br>Source code: <a href="https://nanohub.org/publications/71/1" target="_blank$">
      MIT Virtual source(MVS) HEMT model</a>
<h4>Introduction</h4>
<div class="details">
        <div class="structure-figure">
         <img src="<?php echo base_url('images/simulation/mvshemt120.png');?>" />              
        </div>
        <p>Silicon MIT virtual source (Si-MVS) model is a semi-empirical model that describes the short-channel metal-oxide-semiconductor-field-effect transistor
(MOSFET) current versus voltage characteristics and is valid in all regions of operation with continuity of both current and its derivatives[1]. The model also provides intrinsic charge descriptions that extend all the way to the ballistic regime, where gradual channel approximation
(GCA) is often violated. Rather than calculating all the inter-terminal capacitances separately from the transport model[2], the
intrinsic charges associated with each terminal are calculated self consistently with the current model[3]. The MVS model maintains the
advantage of using only a limited number of input parameters, most of which have straightforward physical meanings and can be easily measured from device
characterization[4].
    </p>
</div>
<h4>References</h4>
<div class="reference clear">
         <p>
                [1]     Khakifirooz, A., O. M. Nayfeh, et al. (2009). "A Simple Semiempirical Short-Channel
                        MOSFET Current Model Voltage Model Continuous Across All Regions of Operation and 
                        Employing Only Physical Parameters." IEEE Transactions on Electron Devices 56(8): 1674-1680
        </p>
        <p>
                [2]   Chan, M., K. Y. Hui, et al. (1998). "A robust and physical non-quasi-static
                      transient AC and small-signal model for circuit simulation." IEEE Transactions on Electron Devices 45(4): 834-841
        </p>
        <p>
                [3]     Wei, L., O. Mysore, et al. (2012). "Virtual-source-based self-consistent current and 
                        charge FET models: from ballistic to drift-diffusion velocity saturation
                        operation." IEEE Transactions on Electron Devices 59(5): 1263-1271
        </p>
        <p>
                [4]    Jeong, C., D. A. Antoniadis, et al. (2009). "On backscattering mobility in 
                       nanoscale silicon MOSFETs." IEEE Transactions on Electron Devices 56(11): 2762-2769
        </p>
</div>


