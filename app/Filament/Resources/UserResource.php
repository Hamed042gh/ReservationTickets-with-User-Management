<?php

namespace App\Filament\Resources;

use App\Models\User;
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
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;


class UserResource extends Resource
{
    // The model associated with this resource, in this case, the User model.
    protected static ?string $model = User::class;

    // The navigation icon for this resource in the Filament panel.
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating or editing User records.
     * Here we define the fields for creating or updating a user.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input for 'user_id' field, marked as required
                TextInput::make('user_id')
                    ->required()   // Field is required
                    ->label('user_id'),  // Field label

                // Input for 'ticket_id' field, marked as required
                TextInput::make('ticket_id')
                    ->required()   // Field is required
                    ->label('ticket_id'),  // Field label

                // DateTime picker for 'reservation_date', marked as required
                DateTimePicker::make('reservation_date')
                    ->required()   // Field is required
                    ->label('reservation_date')  // Field label
                    ->displayFormat('Y-m-d H:i:s'),  // Date format for display

                // Input for 'status' field, numeric type with minimum value of 0
                TextInput::make('status')
                    ->required()   // Field is required
                    ->label('status')  // Field label
                    ->numeric()     // Numeric field
                    ->minValue(0),  // Minimum value is 0
            ]);
    }

    /**
     * Define the table view for displaying user records.
     * This method defines the columns and features of the table.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for 'name', sortable and searchable
                TextColumn::make('name')
                    ->label('name')  // Column label
                    ->sortable()     // Allows sorting
                    ->searchable(),  // Allows searching

                // Column for 'email', sortable and searchable
                TextColumn::make('email')
                    ->label('email')  // Column label
                    ->sortable()      // Allows sorting
                    ->searchable(),   // Allows searching

                // Column for 'password', sortable and searchable
                TextColumn::make('password')
                    ->label('password')  // Column label
                    ->sortable()         // Allows sorting
                    ->searchable(),      // Allows searching

                // Column for 'email_verified_at', displays date in 'Y-m-d' format, sortable and searchable
                TextColumn::make('email_verified_at')
                    ->label('email_verified_at')  // Column label
                    ->date('Y-m-d')               // Date format "Y-m-d"
                    ->sortable()                  // Allows sorting
                    ->searchable(),               // Allows searching

                // Column for 'remember_token', sortable and searchable
                TextColumn::make('remember_token')
                    ->label('remember_token')  // Column label
                    ->sortable()               // Allows sorting
                    ->searchable(),            // Allows searching
            ])
            ->filters([  // Filters for narrowing down results
                SelectFilter::make('role')  // Filter for 'role' field
                    ->label('Role')           // Filter label
                    ->options([  // Filter options
                        'admin' => 'Admin',  // 'admin' option
                        'user' => 'User',    // 'user' option
                    ]),
            ])
            ->actions([  // Actions that can be performed on individual records
                EditAction::make(),  // Edit action
                DeleteAction::make(), // Delete action
            ])
            ->bulkActions([  // Bulk actions for multiple records
                BulkActionGroup::make([  // Group of bulk actions
                    DeleteBulkAction::make(),  // Bulk delete action
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
     * Define the pages for this resource.
     * These are the different pages like listing, creating, and editing users.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),  // The page to list users
            'create' => CreateUser::route('/create'),  // The page to create a new user
            'edit' => EditUser::route('/{record}/edit'),  // The page to edit an existing user
        ];
    }
}
