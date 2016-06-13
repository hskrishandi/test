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
    <svg id="svg">
        <defs>
            <pattern id="smallGrid" width="10" height="10" patternUnits="userSpaceOnUse">
                <path d="M 10 0 H 0 V 10" fill="none" stroke="gray" stroke-width="0.5"/>
            </pattern>
            <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                <rect width="100" height="100" fill="url(#smallGrid)"/>
                <path d="M 50 0 H 0 V 50" fill="none" stroke="gray" stroke-width="1"/>
            </pattern>
        </defs>

        <!-- <g id="workspace" fill="url(#grid)">
            <rect id="gridsystem" width="100%" height="100%" />
            <rect x="0" y="0" width="100" height="100" fill="#cd0000"/>
        </g> -->
    </svg>

    <style media="screen">
        .content {
            margin: 0 !important;
            width: 100% !important;
            overflow: hidden;
        }
        .footer {
            margin-top: 0 !important;
        }
    </style>
    <script type="text/javascript">
        /**
         * @Author Leon 20160608
         */
        $(function(){

            $(".content").css("height", $(window).height() - $(".header").height());
            $(window).resize(function(){
                $(".content").css("height", $(window).height() - $(".header").height());
            });

            var gridSizeFactor = 5;
            var gridWidth = $(".content").width() * gridSizeFactor;
            var gridHeight = $(".content").height() * gridSizeFactor;
            var contentWidth = $(".content").width();
            var contentHeight = $(".content").height();

            var move = function(dx, dy) {
                /*
                 * this.data('viewBox') is set in the start function, use to
                 * record the initial position of the mouse click.
                 * x and y are the final position of
                 * the viewBox
                 */
                var viewBox = this.data('viewBox');
                var x = 0;
                var y = 0
                
                /*
                 * The following two condition blocks is used to control the
                 * boundary of the grid, if nothing out of the boundary,
                 * calculate the new positio of the viewBox
                 */
                if ((viewBox.x - dx) < 0) {
                    x = 0;
                } else if ((viewBox.x - dx) > (gridWidth - contentWidth)) {
                    x = gridWidth - contentWidth;
                } else {
                    x = viewBox.x - dx;
                }
                if ((viewBox.y - dy) < 0) {
                    y = 0;
                } else if ((viewBox.y - dy) > (gridHeight - contentHeight)) {
                    y = gridHeight - contentHeight;
                } else {
                    y = viewBox.y - dy;
                }

                /*
                 * Apply the new position
                 */
                this.attr({
                    viewBox: x + "," + y + "," + viewBox.width + "," + viewBox.height
                });
                console.log('Now dragging');
            }
            var start = function() {
                this.data('viewBox', this.attr("viewBox"));
                console.log('Start dragging');
            }
            var stop = function() {
                console.log('Finished dragging');
            }

            var svg = Snap("#svg").attr({
                width: "100%",
                height: "100%",
                viewBox: (gridWidth - contentWidth) / 2 + "," + (gridHeight - contentHeight) / 2 + "," + contentWidth + "," + contentHeight
            });
            svg.drag(move, start, stop);

            var workspace = svg.g().attr({
                id: "workspace",

            });

            var grid = workspace.rect().attr({
                id: "gridSystem",
                width: gridWidth,
                height: gridHeight,
                fill: "url(#grid)",
            });

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
