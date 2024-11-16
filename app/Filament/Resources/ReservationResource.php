<?php

namespace App\Filament\Resources;


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


class ReservationResource extends Resource
{
    // Define the model associated with this resource (Reservation model in this case)
    protected static ?string $model = Reservation::class;

    // The navigation icon that will appear in the Filament panel for this resource
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating or editing Reservation records.
     * This method defines the form fields, validation rules, and input types.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input for 'user_id' field, required
                TextInput::make('user_id')
                    ->required()
                    ->label('user_id'),

                // Input for 'ticket_id' field, required
                TextInput::make('ticket_id')
                    ->required()
                    ->label('ticket_id'),

                // DateTime picker for 'reservation_date', required, with specific date-time format
                DateTimePicker::make('reservation_date')
                    ->required()
                    ->label('reservation_date')
                    ->displayFormat('Y-m-d H:i:s'),

                // Input for 'status' field, required, numeric with minimum value 0
                TextInput::make('status')
                    ->required()
                    ->label('status')
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    /**
     * Define the table view for listing Reservation records.
     * This method sets up columns, filters, and actions for the table display.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([  // Define the columns to be displayed in the table

                // Column for 'user_id', sortable and searchable
                TextColumn::make('user_id')
                    ->label('user_id')  // Label for the column
                    ->sortable()         // Sorting is enabled for this column
                    ->searchable(),      // Searching is enabled for this column

                // Column for 'ticket_id', sortable and searchable
                TextColumn::make('ticket_id')
                    ->label('ticket_id')  // Label for the column
                    ->sortable()          // Sorting is enabled for this column
                    ->searchable(),       // Searching is enabled for this column

                // Column for 'reservation_date', formatted as a date, sortable and searchable
                TextColumn::make('reservation_date')
                    ->label('reservation_date')  // Label for the column
                    ->date('Y-m-d')              // Date format for the reservation date
                    ->sortable()                 // Sorting is enabled for this column
                    ->searchable(),             // Searching is enabled for this column

                // Column for 'status', sortable and searchable
                TextColumn::make('status')
                    ->label('status')   // Label for the column
                    ->sortable()        // Sorting is enabled for this column
                    ->searchable(),     // Searching is enabled for this column
            ])
            ->filters([  // Filters to narrow down the results displayed in the table

                // Filter for 'status' field with options for different statuses
                SelectFilter::make('status')  // Filter for 'status'
                    ->label('status')           // Label for the filter
                    ->options([                 // Options available for the filter
                        0 => 'pending',          // Option for 'pending' status
                        -1 => 'canceled',        // Option for 'canceled' status
                        1 => 'reserved'          // Option for 'reserved' status
                    ]),
            ])
            ->actions([  // Actions that can be performed on individual records

                // Action for editing a Reservation record
                EditAction::make(),

                // Action for deleting a Reservation record
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
     * This method defines the routes for viewing, creating, and editing Reservation records.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListReservations::route('/'),  // The page to list Reservation records
            'create' => CreateReservation::route('/create'),  // The page to create a new Reservation
            'edit' => EditReservation::route('/{record}/edit'),  // The page to edit an existing Reservation
        ];
    }
}
