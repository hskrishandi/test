<?php extend('layouts/layout.php'); ?>

<?php startblock('title'); ?> Kity
<?php endblock(); ?>

<?php startblock('css'); ?>
<?php echo get_extended_block(); ?>
<?php endblock(); ?>

<?php startblock('script'); ?>
<?php echo get_extended_block(); ?>
<!-- <script type="text/javascript" src="https://cdn.rawgit.com/fex-team/kity/dev/dist/kity.min.js"></script> -->
<script src="<?php echo resource_url('js', 'library/snap.svg-min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<?php endblock(); ?>


<?php startblock('content'); ?>
    <svg id="svg" width="100%" height="500px" style="background-color:#333">
        <defs>
            <pattern id="smallGrid" width="10" height="10" patternUnits="userSpaceOnUse">
                <path d="M 10 0 H 0 V 10" fill="none" stroke="gray" stroke-width="0.5"/>
            </pattern>
            <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                <rect width="100" height="100" fill="url(#smallGrid)"/>
                <path d="M 50 0 H 0 V 50" fill="none" stroke="gray" stroke-width="1"/>
            </pattern>
        </defs>

        <!-- <g id="workspace" transform="matrix(1 0 0 1 0.5 0.5)" fill="url(#grid)">
            <rect id="gridsystem" width="100%" height="100%" />
        </g> -->
        <rect x="0" y="0" width="100" height="100" fill="#cd0000"/>
        <div id="location">
            (0, 0)
        </div>
    </svg>
    <script type="text/javascript">
        $(function(){

            var move = function(dx, dy) {
                var v = this.attr("viewBox")
                this.attr({
                    // transform: this.data('origTransform') + (this.data('origTransform') ? "T" : "t") + [dx, dy]
                    viewBox: (v.x - dx) + "," + (v.y - dy) + "," + v.width + "," + v.height
                });
                $("#location").text(v.x);
            }
            var start = function() {
                console.log('Start dragging');
                this.data('origTransform', this.transform().local );
                // this.data('startPoint')
            }
            var stop = function() {
                console.log('Finished dragging');
            }

            var svg = Snap("#svg");
            svg.attr({
                viewBox: "0,0," + this.width + "," + this.height
            });

            svg.drag(move, start, stop);
            $("#location").text(svg.getBBox().vb);

            /*
            var move = function(dx,dy) {
                this.attr({
                        transform: this.data('origTransform') + (this.data('origTransform') ? "T" : "t") + [dx, dy]
                });
            }
            var start = function() {
                this.data('origTransform', this.transform().local );
            }
            var stop = function() {
                console.log('finished dragging');
            }
            var s = Snap("#svg");


            var workspace = s.g().attr({
                id: "workspace",
                width: "100%",
                height: "100%",
                fill: "url(#grid)",
                transform: "matrix(1 0 0 1 " + -this.width/2 + " " + -this.height/2 + ")",
            });
            var grid = workspace.rect().attr({
                id: "gridsystem",
                width: "500%",
                height: "500%",
            });
            var r1 = workspace.rect(this.width/2, this.height/2, 100, 100, 20, 20);
            r1.attr({
                fill: "rgb(236, 240, 241)",
                   stroke: "#1f2c39",
                   strokeWidth: 3
            });

            workspace.drag(move, start, stop);

            // var block = s.rect(0, 0, 100, 100, 20, 20);
            // block.attr({
            //     fill: "rgb(236, 240, 241)",
            //     stroke: "#1f2c39",
            //     strokeWidth: 3
            // });
            // var z = 0;
            // block.drag();
            */
        });
    </script>
<?php endblock(); ?>
<?php end_extend(); ?>
