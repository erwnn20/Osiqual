@php use App\Models\Company;use App\Models\Contract;use App\Models\Ticket;use App\Models\User;use Illuminate\Pagination\CursorPaginator;use Illuminate\Pagination\LengthAwarePaginator; @endphp

@props([
    'data',
    'filter' => true,
    'edit' => false,
    'error' => 'Aucune données à afficher',
])

<div class="flex flex-col gap-3 bg-red-500/0">

    {{ $slot }}

    @if(!empty($data) && $data->count() > 0)

        @if($filter)
            <div class="flex gap-2" title="not implemented yet">
                <x-input type="search" name="table-search" placeholder="Rechercher..." class="w-full"
                         disabled/>
                <x-button size="md" icon="funnel" color="secondary" disabled>Filtrer</x-button>
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-lg rounded-lg">
            <table class="text-sm text-left text-default-500">

                <thead class="text-sm text-default-700 bg-default-200 border-b-2 border-b-default-300">
                @switch(get_class($data->first()))

                    @case(Ticket::class)
                        <x-table.ticket.head/>
                        @break

                    @case(Contract::class)
                        <x-table.contract.head/>
                        @break

                    @case(Company::class)
                        <x-table.company.head/>
                        @break

                    @case(User::class)
                        <x-table.user.head/>
                        @break

                    @case(Contract\ContractStatus::class)
                    @case(Ticket\TicketCriticality::class)
                    @case(Ticket\TicketPriority::class)
                    @case(Ticket\TicketStatus::class)
                    @case(Contract\ContractType::class)
                    @case(User\Role::class)
                        <x-table.status.head :data="$data->first()"/>
                        @break

                @endswitch
                </thead>

                <tbody>
                @foreach($data as $element)
                    @switch(get_class($data->first()))

                        @case(Ticket::class)
                            <x-table.ticket.row :data="$element" :edit="$edit"/>
                            @break

                        @case(Contract::class)
                            <x-table.contract.row :data="$element" :edit="$edit"/>
                            @break

                        @case(Company::class)
                            <x-table.company.row :data="$element" :edit="$edit"/>
                            @break

                        @case(User::class)
                            <x-table.user.row :data="$element" :edit="$edit"/>
                            @break

                        @case(Contract\ContractStatus::class)
                        @case(Ticket\TicketCriticality::class)
                        @case(Ticket\TicketPriority::class)
                        @case(Ticket\TicketStatus::class)
                        @case(Contract\ContractType::class)
                        @case(User\Role::class)
                            <x-table.status.row :data="$element" :edit="$edit"/>
                            @break

                    @endswitch
                @endforeach
                </tbody>

            </table>

            {{--<!-- Filter modal -->
            <div id="editUserModal" tabindex="-1" aria-hidden="true"
                 class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <form class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div
                            class="flex items-start justify-between p-4 border-b rounded-t border-default-200">
                            <h3 class="text-xl font-semibold text-default-900">
                                Edit user
                            </h3>
                            <button type="button"
                                    class="text-default-400 bg-transparent hover:bg-default-200 hover:text-default-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="editUserModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="first-name"
                                           class="block mb-2 text-sm font-medium text-default-900">First
                                        Name</label>
                                    <input type="text" name="first-name" id="first-name"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="Bonnie" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last-name"
                                           class="block mb-2 text-sm font-medium text-default-900">Last
                                        Name</label>
                                    <input type="text" name="last-name" id="last-name"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="Green" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email" class="block mb-2 text-sm font-medium text-default-900">Email</label>
                                    <input type="email" name="email" id="email"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="example@company.com" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone-number"
                                           class="block mb-2 text-sm font-medium text-default-900">Phone
                                        Number</label>
                                    <input type="number" name="phone-number" id="phone-number"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="e.g. +(12)3456 789" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="department"
                                           class="block mb-2 text-sm font-medium text-default-900">Department</label>
                                    <input type="text" name="department" id="department"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="Development" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="company"
                                           class="block mb-2 text-sm font-medium text-default-900">Company</label>
                                    <input type="number" name="company" id="company"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="123456" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="current-password"
                                           class="block mb-2 text-sm font-medium text-default-900">Current
                                        Password</label>
                                    <input type="password" name="current-password" id="current-password"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="••••••••" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="new-password"
                                           class="block mb-2 text-sm font-medium text-default-900">New
                                        Password</label>
                                    <input type="password" name="new-password" id="new-password"
                                           class="shadow-xs bg-default-50 border border-default-300 text-default-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                           placeholder="••••••••" required="">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-default-200 rounded-b">
                            <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Save all
                            </button>
                        </div>
                    </form>
                </div>
            </div>--}}
        </div>

        @if ($data instanceof LengthAwarePaginator)
            {{ $data->withQueryString()->links('components.page.paginator') }}
        @endif

    @else

        <div class="backdrop-blur-md shadow-lg rounded-lg bg-default-200/30 h-32 flex justify-center items-center">
            <span class="italic">{{ $error }}</span>
        </div>

    @endif

</div>
