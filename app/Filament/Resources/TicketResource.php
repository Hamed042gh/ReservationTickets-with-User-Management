<?php

namespace App\Filament\Resources;


use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\Pages\EditTicket;
use App\Filament\Resources\TicketResource\Pages\ListTickets;
use App\Filament\Resources\TicketResource\Pages\CreateTicket;


class TicketResource extends Resource
{
    // Define the model associated with the resource
    protected static ?string $model = Ticket::class;

    // Set the icon for the resource in the navigation panel
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form for creating and editing a ticket.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input for 'origin' field, required
                TextInput::make('origin')
                    ->required()
                    ->label('origin'),

                // Input for 'destination' field, required
                TextInput::make('destination')
                    ->required()
                    ->label('destination'),

                // DateTime picker for 'departure_date', required
                DateTimePicker::make('departure_date')
                    ->required()
                    ->label('departure_date')
                    ->displayFormat('Y-m-d H:i:s'),

                // Input for 'amount', required, numeric with minimum value 0
                TextInput::make('amount')
                    ->required()
                    ->label('amount')
                    ->numeric()
                    ->minValue(0),

                // Input for 'available_count', required, numeric with minimum value 0
                TextInput::make('available_count')
                    ->required()
                    ->label('available_count')
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    /**
     * Define the table view for listing tickets.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for 'origin', sortable and searchable
                TextColumn::make('origin')->label('origin')->sortable()
                    ->searchable(),

                // Column for 'destination', sortable and searchable
                TextColumn::make('destination')->label('destination')->sortable()
                    ->searchable(),

                // Column for 'departure_date', sortable and searchable, formatted as date
                TextColumn::make('departure_date')->label('departure_date')->date('Y-m-d')->sortable()
                    ->searchable(),

                // Column for 'available_count', sortable and searchable
                TextColumn::make('available_count')->label('available_count')->sortable()
                    ->searchable(),
                TextColumn::make('amount')->label('amount')->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Filter for 'origin' field with options for Iranian provinces
                SelectFilter::make('origin')
                    ->label('Origin')
                    ->options([
                        'Alborz' => 'Alborz',
                        'Ardabil' => 'Ardabil',
                        'Bushehr' => 'Bushehr',
                        'Chaharmahal and Bakhtiari' => 'Chaharmahal and Bakhtiari',
                        'East Azerbaijan' => 'East Azerbaijan',
                        'Fars' => 'Fars',
                        'Gilan' => 'Gilan',
                        'Golestan' => 'Golestan',
                        'Hamedan' => 'Hamedan',
                        'Hormozgan' => 'Hormozgan',
                        'Ilam' => 'Ilam',
                        'Isfahan' => 'Isfahan',
                        'Kerman' => 'Kerman',
                        'Kermanshah' => 'Kermanshah',
                        'Khuzestan' => 'Khuzestan',
                        'Kohgiluyeh and Boyer-Ahmad' => 'Kohgiluyeh and Boyer-Ahmad',
                        'Kurdistan' => 'Kurdistan',
                        'Lorestan' => 'Lorestan',
                        'Markazi' => 'Markazi',
                        'Mazandaran' => 'Mazandaran',
                        'North Khorasan' => 'North Khorasan',
                        'Qazvin' => 'Qazvin',
                        'Qom' => 'Qom',
                        'Razavi Khorasan' => 'Razavi Khorasan',
                        'Semnan' => 'Semnan',
                        'Sistan and Baluchestan' => 'Sistan and Baluchestan',
                        'South Khorasan' => 'South Khorasan',
                        'Tehran' => 'Tehran',
                        'West Azerbaijan' => 'West Azerbaijan',
                        'Yazd' => 'Yazd',
                        'Zanjan' => 'Zanjan',
                    ]),

                // Filter for 'destination' field with similar options for provinces
                SelectFilter::make('destination')
                    ->label('Destination')
                    ->options([
                        'Alborz' => 'Alborz',
                        'Ardabil' => 'Ardabil',
                        'Bushehr' => 'Bushehr',
                        'Chaharmahal and Bakhtiari' => 'Chaharmahal and Bakhtiari',
                        'East Azerbaijan' => 'East Azerbaijan',
                        'Fars' => 'Fars',
                        'Gilan' => 'Gilan',
                        'Golestan' => 'Golestan',
                        'Hamedan' => 'Hamedan',
                        'Hormozgan' => 'Hormozgan',
                        'Ilam' => 'Ilam',
                        'Isfahan' => 'Isfahan',
                        'Kerman' => 'Kerman',
                        'Kermanshah' => 'Kermanshah',
                        'Khuzestan' => 'Khuzestan',
                        'Kohgiluyeh and Boyer-Ahmad' => 'Kohgiluyeh and Boyer-Ahmad',
                        'Kurdistan' => 'Kurdistan',
                        'Lorestan' => 'Lorestan',
                        'Markazi' => 'Markazi',
                        'Mazandaran' => 'Mazandaran',
                        'North Khorasan' => 'North Khorasan',
                        'Qazvin' => 'Qazvin',
                        'Qom' => 'Qom',
                        'Razavi Khorasan' => 'Razavi Khorasan',
                        'Semnan' => 'Semnan',
                        'Sistan and Baluchestan' => 'Sistan and Baluchestan',
                        'South Khorasan' => 'South Khorasan',
                        'Tehran' => 'Tehran',
                        'West Azerbaijan' => 'West Azerbaijan',
                        'Yazd' => 'Yazd',
                        'Zanjan' => 'Zanjan',
                    ]),


                // Filter for 'available_count' field with ranges for available tickets
                SelectFilter::make('available_count')
                    ->label('Available Count')
                    ->options([
                        '1-10' => '1 - 10',
                        '11-20' => '11 - 20',
                        '21-30' => '21 - 30',
                        '31-40' => '31 - 40',
                    ]),
            ])
            ->actions([
                // Action for editing a ticket
                EditAction::make(),

                // Action for deleting a ticket
                DeleteAction::make(),
            ])
            ->bulkActions([
                // Bulk action for deleting multiple tickets
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define any relationships for the model (currently none).
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Define the pages for the resource, such as listing, creation, and editing.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }
}
