<?php

namespace App\Filament\Resources;

use App\Models\User;
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
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\TicketResource\Pages\EditTicket;
use App\Filament\Resources\TicketResource\Pages\ListTickets;
use App\Filament\Resources\TicketResource\Pages\CreateTicket;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

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

                TextColumn::make('name')
                    ->label('name')
                    ->sortable()
                    ->searchable(),

                // Column for 'destination', sortable and searchable
                TextColumn::make('email')
                    ->label('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('password')
                    ->label('password')
                    ->sortable()
                    ->searchable(),



                TextColumn::make('email_verified_at')
                    ->label('email_verified_at')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('remember_token')
                    ->label('remember_token')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                SelectFilter::make('role')->label('Role')->options([
                    'admin' => 'Admin',
                    'user' => 'User',
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
