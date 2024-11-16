<?php

namespace App\Filament\Resources;

use App\Models\Ticket;
use App\Models\Payment;
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
use App\Filament\Resources\PaymentResource\Pages\EditPayment;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use App\Filament\Resources\PaymentResource\Pages\CreatePayment;
use App\Filament\Resources\ReservationResource\Pages\EditReservation;
use App\Filament\Resources\ReservationResource\Pages\ListReservations;
use App\Filament\Resources\ReservationResource\Pages\CreateReservation;
use App\Filament\Resources\ReservationResource\RelationManagers\ReservationUserRelationManager;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
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


                TextColumn::make('user.name')
                    ->label('userName')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('reservation.id')
                    ->label('Reservation.id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('track_id')
                    ->label('Track_id')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('reservation.reservation_date')
                    ->label('Reservation_date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([

                SelectFilter::make('status')
                    ->label('status')
                    ->options([
                        'pending' => 'pending',
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayment::route('/create'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }
}
