<?php

namespace App\Filament\Resources;

use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservation;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ReservationResource\Pages\EditReservation;
use App\Filament\Resources\ReservationResource\Pages\ListReservations;
use App\Filament\Resources\ReservationResource\Pages\CreateReservation;
use App\Filament\Resources\ReservationResource\RelationManagers\ReservationUserRelationManager;


class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input for 'origin' field, required
                TextInput::make('user_id')
                    ->required()
                    ->label('user_id'),

                // Input for 'destination' field, required
                TextInput::make('ticket_id')
                    ->required()
                    ->label('ticket_id'),

                // DateTime picker for 'departure_date', required
                DateTimePicker::make('reservation_date')
                    ->required()
                    ->label('reservation_date')
                    ->displayFormat('Y-m-d H:i:s'),

                // Input for 'amount', required, numeric with minimum value 0
                TextInput::make('status')
                    ->required()
                    ->label('status')
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

                TextColumn::make('user_id')->label('user_id')->sortable()
                    ->searchable(),

                // Column for 'destination', sortable and searchable
                TextColumn::make('ticket_id')->label('ticket_id')->sortable()
                    ->searchable(),


                // Column for 'departure_date', sortable and searchable, formatted as date
                TextColumn::make('reservation_date')->label('reservation_date')->date('Y-m-d')->sortable()
                    ->searchable(),

                // Column for 'available_count', sortable and searchable
                TextColumn::make('status')->label('status')->sortable()
                    ->searchable(),

            ])
            ->filters([
                // Filter for 'origin' field with options for Iranian provinces
                SelectFilter::make('status')
                    ->label('status')
                    ->options([
                        0 => 'pending',
                        -1 => 'canceled',
                        1 => 'reserved'
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

    public static function getPages(): array
    {
        return [
            'index' => ListReservations::route('/'),
            'create' => CreateReservation::route('/create'),
            'edit' => EditReservation::route('/{record}/edit'),
        ];
    }
}
