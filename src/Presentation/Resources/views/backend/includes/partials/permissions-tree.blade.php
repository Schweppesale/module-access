<div id="available-permissions" class="" style="margin-top:10px;">

    <div class="row">

        <div class="col-md-12">

            <p><strong>Grouped Permissions</strong></p>

            <div class="col-md-6">

                @if (count($groups))

                    <div id="permission-tree">

                        <ul>
                            @foreach ($groups as $group)

                                <li>{!! $group->getName() !!}

                                    @if ($group->getPermissions()->count())
                                        <ul>
                                            @foreach ($group->getPermissions() as $permission)

                                                <li id="{!! $permission->getId() !!}"
                                                    data-dependencies="{!! json_encode($permission->getDependencies()->map(function($entity){
                                                        return $entity->getId();
                                                    })->toArray()) !!}">

                                                    @if ($permission->getDependencies()->count())
                                                        <?php
                                                        //Get the dependency list for the tooltip
                                                        $dependency_list = [];
                                                        foreach ($permission->getDependencies() as $dependency)
                                                            array_push($dependency_list, $dependency->getDisplayName());
                                                        $dependency_list = implode(", ", $dependency_list);
                                                        ?>

                                                        <a data-toggle="tooltip" data-html="true"
                                                           title="<strong>Dependencies:</strong> {!! $dependency_list !!}">{!! $permission->getDisplayName() !!}
                                                            <small><strong>(D)</strong></small>
                                                        </a>
                                                    @else
                                                        {!! $permission->getDisplayName() !!}
                                                    @endif

                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($group->getChildren()->count())
                                        <ul>
                                            @foreach ($group->getChildren() as $child)

                                                <li>{!! $child->getName() !!}

                                                    @if ($child->getPermissions()->count())

                                                        <ul style="padding-left:40px;font-size:.8em">
                                                            @foreach ($child->getPermissions() as $permission)

                                                                <li id="{!! $permission->getId() !!}"
                                                                    data-dependencies="{!! json_encode($permission->getDependencies()->map(function($entity){
                                                                        return $entity->getId();
                                                                    })->toArray()) !!}">

                                                                    @if ($permission->getDependencies()->count())
                                                                        <?php
                                                                        //Get the dependency list for the tooltip
                                                                        $dependency_list = [];
                                                                        foreach ($permission->getDependencies() as $dependency)
                                                                            array_push($dependency_list, $dependency->getDisplayName());
                                                                        $dependency_list = implode(", ", $dependency_list);
                                                                        ?>
                                                                        <a data-toggle="tooltip" data-html="true"
                                                                           title="<strong>Dependencies:</strong> {!! $dependency_list !!}">{!! $permission->getDisplayName() !!}
                                                                            <small><strong>(D)</strong></small>
                                                                        </a>
                                                                    @else
                                                                        {!! $permission->getDisplayName() !!}
                                                                    @endif

                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p>There are no permission groups.</p>
                @endif
            </div><!--col-lg-6-->
        </div><!--col-lg-12-->

    </div><!--row-->
</div><!--available permissions-->


@section('after-scripts-end')

    <script type="text/javascript">

        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }

        $(function () {

            @foreach ($entity_permissions as $permission)
                tree.jstree('check_node', '#{!! $permission !!}');
            @endforeach


        });

        (function () {
            $("form").submit(function () {

                var checked_ids = tree.jstree("get_checked", false);
                var numeric_ids = [];

                $("input[name='ungrouped[]']").each(function () {
                    checked_ids.push($(this).val());
                });

                for (i = 0; i < checked_ids.length; i++) {
                    var id = checked_ids[i];
                    if (isNumeric(id) == true) {
                        numeric_ids.push(id);
                    }
                }

                $("input[name='permissions']").val(numeric_ids);
            });
        }());

    </script>


    {!! HTML::script('js/backend/plugin/jstree/jstree.min.js') !!}
    {!! HTML::script('js/backend/access/roles/script.js') !!}


    {!! HTML::script('js/backend/access/permissions/script.js') !!}
    {!! HTML::script('js/backend/access/users/script.js') !!}
@stop