<x-filament-panels::page>
    <x-filament::section >
        <div>
            <div class="flex justify-between xl:gap-60 lg:gap-48 md:gap-16 sm:gap-8 sm:flex-row flex-col gap-4">
                <div class="w-full">
                    <div>
                        <img src="{{url('storage/' . setting('site_logo'))}}" alt="{{setting('site_name')}}" class="w-16">
                    </div>
                    <div class="flex flex-col">
                        <div class="text-sm text-gray-400  mt-3">
                            {{__('Bill From')}}:
                        </div>
                        <div class="text-lg font-bold">
                            {{$this->getRecord()->billedFrom->name}}
                        </div>
                        <div class="text-sm">
                            {{$this->getRecord()->billedFrom->phone}}
                        </div>
                        <div class="text-sm">
                            {{$this->getRecord()->billedFrom->address}}
                        </div>
                        <div class="text-sm">
                            {{$this->getRecord()->billedFrom->zip}} {{$this->getRecord()->billedFrom->city}}
                        </div>
                        <div class="text-sm">
                            {{$this->getRecord()->billedFrom->country?->name}}
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="mt-4">
                            <div class="text-sm text-gray-400">
                                {{__('Bill To')}}:
                            </div>
                            <div class="text-lg font-bold">
                                {{$this->getRecord()->billedFor?->name}}
                            </div>
                            <div class="text-sm">
                                {{$this->getRecord()->billedFor?->email}}
                            </div>
                            <div class="text-sm">
                                {{$this->getRecord()->billedFor?->phone}}
                            </div>
                            @php
                                $address = $this->getRecord()->billedFor?->locations()->first();
                            @endphp
                            @if($address)
                                <div class="text-sm">
                                    {{$address->street}}
                                </div>
                                <div class="text-sm">
                                    {{$address->zip}}, {{$address->city->name}}
                                </div>
                                <div class="text-sm">
                                    {{$this->getRecord()->billedFor?->locations()->first()?->country->name}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <div class="flex justify-end font-bold">
                        <div>
                            <div>
                                <h1 class="text-3xl">{{__('INVOICE')}}</h1>
                            </div>
                            <div>
                                #{{$this->getRecord()->uuid}}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end h-full">
                        <div class="flex flex-col justify-end">
                            <div>
                                <div class="flex justify-between gap-4">
                                    <div class="text-gray-400">{{__('Issue Date')}} : </div>
                                    <div>{{$this->getRecord()->created_at->toDateString()}}</div>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <div class="text-gray-400">{{__('Due Date')}} : </div>
                                    <div>{{$this->getRecord()->due_date->toDateString()}}</div>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <div class="text-gray-400">{{__('Status')}} : </div>
                                    <div>{{type_of($this->getRecord()->status, 'invoices', 'status')->name}}</div>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <div class="text-gray-400">{{__('Type')}} : </div>
                                    <div>{{type_of($this->getRecord()->type, 'invoices', 'type')->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg my-4 px-2">
                    <div class="flex flex-col">
                        <div class="flex justify-between  px-4 py-2 border-gray-200 dark:border-gray-700 font-bold border-b text-start">
                            <div class="p-2 w-full">
                                {{__('Item')}}
                            </div>
                            <div class="p-2 w-full">
                                {{__('Total')}}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 divide-y divide-gray-100 dark:divide-white/5">
                        @foreach($this->getRecord()->invoicesitems as $key=>$item)
                            <div class="flex justify-between px-4 py-2">
                                <div class="flex flex-col w-full">
                                    <div class="flex justify-start">
                                        <div>
                                            <div class="font-bold text-lg">
                                                {{ $item->item }}
                                            </div>
                                            @if($item->description)
                                                <div class="text-gray-400">
                                                    {{ $item->description }}
                                                </div>
                                            @endif
                                            @if($item->options)
                                                <div class="text-gray-400">
                                                    @foreach($item->options  ?? [] as $label=>$options)
                                                        <span>{{  str($label)->ucfirst() }}</span> : {{$options}} <br>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="p-2">
                                        <div class="flex flex-col mt-2">
                                            <div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-gray-400 w-full">PRICE:</span>
                                                    <span class="w-full">
                                                    {{ number_format($item->price, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }} </small>
                                                </span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-gray-400 w-full">VAT:</span>
                                                    <span class="w-full">
                                                    {{ number_format($item->tax, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                                                </span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-gray-400 w-full">DISCOUNT:</span>
                                                    <span class="w-full">
                                                    {{ number_format($item->discount, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                                                </span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-gray-400 w-full">QTY:</span>
                                                    <span class="w-full">
                                                    {{ $item->qty }}
                                                </span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-gray-400 w-full">TOTAL:</span>
                                                    <span class="w-full font-bold">
                                                        {{ number_format($item->total, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <div class="flex flex-col justify-end gap-4 w-full">
                        @if($this->getRecord()->is_bank_transfer)
                            <div>
                                <div class="mb-2 text-xl">
                                    {{__('Bank Account')}}
                                </div>
                                <div class="text-sm flex flex-col">
                                    <div>
                                        <span clas="text-gray-400">{{__('Name')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_name }}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('Address')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_address }}, {{ $this->getRecord()->bank_city }}, {{ $this->getRecord()->bank_country}}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('Branch')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_branch }}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('SWIFT')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_swift }}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('Account')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_account }}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('Owner')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_account_owner }}</span>
                                    </div>
                                    <div>
                                        <span clas="text-gray-400">{{__('IBAN')}}</span> : <span class="font-bold">{{ $this->getRecord()->bank_iban }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <div class="mb-2 text-xl">
                                {{__('Signature')}}
                            </div>
                            <div class="text-sm text-gray-400">
                                <div>
                                    {{ $this->getRecord()->billedFrom?->name }}
                                </div>
                                <div>
                                    {{ $this->getRecord()->billedFrom?->email }}
                                </div>
                                <div>
                                    {{ $this->getRecord()->billedFrom?->phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-4  w-full">
                        <div class="flex justify-between">
                            <div class="font-bold">
                                {{__('Sub Total')}}
                            </div>
                            <div>
                                {{ number_format(($this->getRecord()->total + $this->getRecord()->discount) - ($this->getRecord()->vat + $this->getRecord()->shipping), 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="font-bold">
                                {{__('Tax')}}
                            </div>
                            <div>
                                {{ number_format($this->getRecord()->vat, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="font-bold">
                                {{__('Discount')}}
                            </div>
                            <div>
                                {{ number_format($this->getRecord()->discount, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                            </div>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="font-bold">
                                {{__('Paid')}}
                            </div>
                            <div>
                                {{ number_format($this->getRecord()->paid, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                            </div>
                        </div>
                        <div class="flex justify-between text-xl font-bold">
                            <div>
                                {{__('Balance Due')}}
                            </div>
                            <div>
                                {{ number_format($this->getRecord()->total-$this->getRecord()->paid, 2) }}<small class="text-md font-normal">{{ $this->getRecord()->currency?->iso }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                @if($this->getRecord()->notes)
                    <div class="border-b border-gray-200 dark:border-gray-700 my-4"></div>
                    <div>
                        <div class="mb-2 text-xl">
                            {{__('Notes')}}
                        </div>
                        <div class="text-sm text-gray-400">
                            {!! $this->getRecord()->notes !!}
                        </div>
                    </div`>
                @endif
            </div>
        </div>
    </x-filament::section>
    <div class="no-print">
        @php
            $relationManagers = $this->getRelationManagers();
            $hasCombinedRelationManagerTabsWithContent = $this->hasCombinedRelationManagerTabsWithContent();
        @endphp
        @if (count($relationManagers))
            <x-filament-panels::resources.relation-managers
                :active-locale="isset($activeLocale) ? $activeLocale : null"
                :active-manager="$this->activeRelationManager ?? ($hasCombinedRelationManagerTabsWithContent ? null : array_key_first($relationManagers))"
                :content-tab-label="$this->getContentTabLabel()"
                :content-tab-icon="$this->getContentTabIcon()"
                :content-tab-position="$this->getContentTabPosition()"
                :managers="$relationManagers"
                :owner-record="$record"
                :page-class="static::class"
            >
                @if ($hasCombinedRelationManagerTabsWithContent)
                    <x-slot name="content">
                        @if ($this->hasInfolist())
                            {{ $this->infolist }}
                        @else
                            {{ $this->form }}
                        @endif
                    </x-slot>
                @endif
            </x-filament-panels::resources.relation-managers>
        @endif
    </div>
    <style type="text/css" media="print">
        .fi-section {
            border: none;
            box-shadow: none;
        }
        .no-print { display: none; }
        .fi-header { display: none; }
        .fi-topbar { display: none; }
        aside { display: none; }
    </style>

</x-filament-panels::page>
