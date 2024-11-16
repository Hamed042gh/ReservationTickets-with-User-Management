<?php

namespace App\Filament\Resources;


use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PaymentResource\Pages\EditPayment;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use App\Filament\Resources\PaymentResource\Pages\CreatePayment;



class PaymentResource extends Resource
{
    // The model associated with this resource, in this case, the Payment model.
    protected static ?string $model = Payment::class;

    // The navigation icon for this resource in the Filament panel.
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating or editing Payment records.
     * This method is used to define the fields in the payment form (currently empty in this case).
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([]); // The form schema is currently empty.
    }

    /**
     * Define the table view for displaying Payment records.
     * This method sets up the columns to be displayed in the table, with options for sorting and searching.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([  // Define the columns to display in the table

                // Column for the user's name, sortable and searchable
                TextColumn::make('user.name')
                    ->label('Name')  // The label for this column
                    ->sortable()     // Allows sorting by name
                    ->searchable(),  // Allows searching by name

                // Column for the reservation ID, sortable and searchable
                TextColumn::make('reservation.id')
                    ->label('Reservation.id')  // The label for this column
                    ->sortable()               // Allows sorting by reservation ID
                    ->searchable(),            // Allows searching by reservation ID

                // Column for the track ID, sortable and searchable
                TextColumn::make('track_id')
                    ->label('Track_id')  // The label for this column
                    ->sortable()         // Allows sorting by track ID
                    ->searchable(),      // Allows searching by track ID

                // Column for the reservation date, formatted as a date, sortable and searchable
                TextColumn::make('reservation.reservation_date')
                    ->label('Reservation_date')  // The label for this column
                    ->date('Y-m-d')              // Date format for reservation date
                    ->sortable()                 // Allows sorting by reservation date
                    ->searchable(),              // Allows searching by reservation date

                // Column for the status, sortable and searchable
                TextColumn::make('status')
                    ->label('Status')  // The label for this column
                    ->sortable()       // Allows sorting by status
                    ->searchable(),    // Allows searching by status
            ])
            ->filters([  // Filters to narrow down the results displayed in the table

                // Filter to choose the status of the payment
                SelectFilter::make('status')  // Filter for 'status'
                    ->label('status')           // The label for this filter
                    ->options([  // Options available for the status filter
                        'pending' => 'pending',    // Pending status
                        -1 => 'canceled',          // Canceled status
                        1 => 'reserved'            // Reserved status
                    ]), 
            ])
            ->actions([  // Actions that can be performed on individual records

                // Action for editing a payment record
                EditAction::make(),

                // Action for deleting a payment record
                DeleteAction::make(),
            ])
            ->bulkActions([  // Bulk actions that can be performed on multiple records

                // Group of bulk actions, currently includes only the delete action
                BulkActionGroup::make([
                    DeleteBulkAction::make(),  // Action for deleting multiple records
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
        return [];  // No relationships are defined for this resource.
    }

    /**
     * Define the pages for this resource.
     * This method defines the routes for viewing, creating, and editing payment records.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListPayments::route('/'),  // The page to list payment records
            'create' => CreatePayment::route('/create'),  // The page to create a new payment
            'edit' => EditPayment::route('/{record}/edit'),  // The page to edit an existing payment
        ];
    }
}
