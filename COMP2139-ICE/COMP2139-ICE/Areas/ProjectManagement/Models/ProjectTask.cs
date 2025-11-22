using System.ComponentModel.DataAnnotations;

namespace COMP2139_ICE.Areas.ProjectManagement.Models;

public class ProjectTask
{
    [Key]
    public int ProjectTaskId { get; set; }

    [Required]
    [Display(Name = "Task Title")]
    [StringLength(100)]
    public string Title { get; set; }

    [Required]
    [Display(Name = "Task Description")]
    [DataType(DataType.MultilineText)]
    public string Description { get; set; }

    public int ProjectId { get; set; }

    public Project? Project { get; set; }
}