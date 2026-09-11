<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'type',
        'amount',
        'transaction_date',
        'description',
        'notes',
        'receipt_path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    /**
     * Get the category that owns the transaction.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor for receipt full public URL.
     */
    protected function receiptUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->receipt_path ? Storage::url($this->receipt_path) : null,
        );
    }

    /**
     * Formatted Rupiah attribute.
     */
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp '.number_format((float) $this->amount, 0, ',', '.'),
        );
    }

    /**
     * Scope a query to only include income transactions.
     */
    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope a query to only include expense transactions.
     */
    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope a query to filter transactions.
     *
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $q, string $search) {
                $q->where(function (Builder $sub) use ($search) {
                    $sub->where('description', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%");
                });
            })
            ->when($filters['type'] ?? null, function (Builder $q, string $type) {
                if (in_array($type, ['income', 'expense'], true)) {
                    $q->where('type', $type);
                }
            })
            ->when($filters['category_id'] ?? null, function (Builder $q, $categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($filters['start_date'] ?? null, function (Builder $q, string $startDate) {
                $q->whereDate('transaction_date', '>=', $startDate);
            })
            ->when($filters['end_date'] ?? null, function (Builder $q, string $endDate) {
                $q->whereDate('transaction_date', '<=', $endDate);
            });
    }
}
